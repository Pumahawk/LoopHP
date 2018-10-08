<?php

namespace LoopHP;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use LoopHP\Config\Loader\PhpLoader;
use LoopHP\Config\Loader\YamlLoader;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;


class App {
  protected $match;
  protected $configuration;
  public function __construct(AppConfiguration $configuration, Matchable $match) {
    $this -> configuration = $configuration;
    $this -> match = $match;
  }
  public function start() {
     // TODO gestire il path multiplo del template
    $filesystemLoader = new FilesystemLoader($this -> configuration -> getTemplate()[0].'/%name%');
    $fileLocator = new FileLocator($this -> configuration -> getConfigurationPath());
    $engineInterface = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    $cData = new ControllerData();
    $loader = new PhpLoader($fileLocator);

    $controllerData = $this -> match -> match();
    $controller = $controllerData -> getController();
    $method = $controllerData -> getMethod();
    $obj = new $controller($engineInterface, $cData, $loader);
    $obj -> $method();
  }
  public function match() : ControllerData {
    return $this -> match -> match();
  }
  public function getConfigLoader() : LoaderInterface {
    $fileLocator = new FileLocator($this -> configuration -> getConfigurationPath());
    $loadResolver = new LoaderResolver();
    $loadResolver -> addLoader(new PhpLoader($fileLocator));
    $loadResolver -> addLoader(new YamlLoader($fileLocator));
    $delegatingLoader = new DelegatingLoader($loadResolver);
    return $delegatingLoader;
  }
  public function setApiLoader() {
    $template = $this -> configuration -> getApi();
    foreach ($template as $namespace => $path ) {
      $this -> configuration -> getComposer() -> addPsr4($namespace, $path);
    }
  }
}
