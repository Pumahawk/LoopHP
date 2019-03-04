<?php

namespace LoopHP;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Config\Loader\DelegatingLoader;
use LoopHP\Config\Loader\PhpLoader;
use LoopHP\Config\Loader\YamlLoader;
use LoopHP\Config\Loader\PhpRouterLoader;
use LoopHP\Config\Loader\YamlRouterLoader;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\TemplateNameParser;

/**
  * Classe principale di LoopHP.
  * 
  * Permette di inizializzare una applicazione con la creazione di un oggeto di tipo
  * App a cui viene passato un oggetto di configurazione di tipo AppConfiguration e
  * un oggetto che implementa Matchable.
  * Il metodo start avvia l'esecuzione dell'applicazione.
*/

class App {
  protected $match;
  protected $configuration;
  protected $templateEngine;
  protected $loaderResolver;

  public function __construct(AppConfiguration $configuration, $match = null) {
    $this -> configuration = $configuration;
    $this -> match = $match;
    $this -> templateEngine = new DelegatingEngine();

    $filesystemLoader = new FilesystemLoader($this -> configuration -> getTemplate().'/%name%');
    $phpEngine = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    $phpEngine -> set(new SlotsHelper());
    $this -> templateEngine -> addEngine($phpEngine);

    $fileLocator = new FileLocator($this -> configuration -> getConfigurationPath());
    $loadResolver = new LoaderResolver();
    $loadResolver -> addLoader(new PhpRouterLoader($fileLocator));
    $loadResolver -> addLoader(new YamlRouterLoader($fileLocator));
    $loadResolver -> addLoader(new PhpLoader($fileLocator));
    $loadResolver -> addLoader(new YamlLoader($fileLocator));
    $this -> loaderResolver = $loadResolver;
  }

  /**
   * Permette di aggiunfere un template engine per riconoscere template diversi da quelli php.
   * Metodo da usare soltanto per estendere le funzionalita dell'applicazione. Di default e' presente
   * il template engine di Symfony PHPEngine.
   * 
   * @param EngineInterface $engineInterface Template engine da aggiungere.
   */
  // TODO Da testare
  public function addTemplateEngine(EngineInterface $engineInterface) {
    $this -> templateEngine -> addEngine($engineInterface);
  }

  
  /**
   * Restituisce il template engine in grado di gestire i template.
   * 
   * @return EngineInterface
   */
  public function template() {
    return $this -> templateEngine;
  }

  /**
   * Permette di aggiungere dei LoaderResolverInterface in modo da aumentare
   * la compatibilita con i diversi file di configurazione.
   * 
   * @param LoaderResolverInterface $loader
   */
  // TODO Da testare
  public function addConfigLoader(LoaderResolverInterface $loader) {
    $this -> loaderResolver -> addLoader($loader);
  }

  /**
   * Imposta il match dell'applicazione.
   * 
   * @param Matchable $match
   */
  public function setMatch(Matchable $match) {
    $this -> match = $match;
  }
  
  /**
   * Restituisce l'oggetto match dell'applicazione.
   * 
   * @return Matchable
   */
  public function getMatch() {
    return $this -> match;
  }
  
  /**
   * Avvia l'applicazione eseguendo il metodo del controller restituito dal matcher.
   */
  public function start() {
    $loader = $this -> getConfigLoader();

    $controllerData = $this -> match -> match();
    $controller = $controllerData -> getController();
    $method = $controllerData -> getMethod();
    $obj = new $controller($this -> templateEngine, $controllerData, $loader);
    $obj -> $method();
  }
  
  /**
   * Esegue il metodo match dell'oggetto match e restituisce il ControllerData.
   * 
   * @return ControllerData
   */
  public function match() : ControllerData {
    return $this -> match -> match();
  }
  
  /**
   * Restituisce l'oggetto LoaderInterface associato all'applicazione, che permette di 
   * caricare processare i file di configurazione.
   * 
   * @return LoaderInterface
   */
  public function getConfigLoader() : LoaderInterface {
    $delegatingLoader = new DelegatingLoader($this -> loaderResolver);
    return $delegatingLoader;
  }
  
  /**
   * Utilizza il metodo addPsr4 di composer per aggiungere le Api assegnate all'autoload di composer.
   */
  public function setApiLoader() {
    $template = $this -> configuration -> getApi();
    foreach ($template as $namespace => $path ) {
      $this -> configuration -> getComposer() -> addPsr4($namespace, $path);
    }
  }
  public function loader() {
    return $this -> getConfigLoader();
  }
}
