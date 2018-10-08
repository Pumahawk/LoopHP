<?php

namespace LoopHP;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use LoopHP\Config\Loader\PhpLoader;
use LoopHP\Config\Loader\YamlLoader;

class App {
  protected $match;
  protected $configuration;
  public function __construct(AppConfiguration $configuration, Matchable $match) {
    $this -> configuration = $configuration;
    $this -> match = $match;
  }
  public function start() {
    // TODO da testare
    $controllerData = $this -> match -> match();
    $controller = $controllerData -> getController();
    $method = $controllerData -> getMethod();
    $obj = new $controller();
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
