<?php

namespace LoopHP;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use LoopHP\Config\Loader\YamlRouterLoader;
use LoopHP\Config\Loader\PhpRouterLoader;

use Symfony\Component\Routing\Route;

// TODO App da testare
class App {
  protected $configuration;
  protected $controllable;
  protected $routeCollection;

  public function __construct(AppConfiguration $configuration, ControllableInterface $controllable) {
    $this -> configuration = $configuration;
    $this -> controllable = $controllable;
  }

  public function setConfiguration(AppConfiguration $configuration) {
    $this -> configuration = $configuration;
  }

  public function getConfiguration() : AppConfiguration{
    return $this -> configuration;
  }

  public function controllerExecution(array $data) {
    // TODO
  }

  public function match() {
    return $this -> controllable -> getController($this -> routeCollection);
  }

  public function run() {
    $this -> setComposerAutorun();
    $this -> loadRouteCollection();

    $data = $this -> match();
    $this -> controllerExecution($data);
  }

  public function setComposerAutorun() { //TODO test
    $cd = $configuration -> getConfigurationDefinition();
    $api = $cd -> getApi();

    foreach ($api as $a) {
      $cd -> getComposerObject() -> addPsr4('LoopHP\\Api\\', $a);
    }
  }

  public function loadRouteCollection() {
    $cd = $configuration -> getConfigurationDefinition();
    $path = $cd -> getRouterPath();
    $fl = new FileLocator($path);

    $loaderResolver = new LoaderResolver(
      array(
        new YamlRouterLoader($fileLocator),
        new PhpRouterLoader($fileLocator)
      )
    );
    $delegatingLoader = new DelegatingLoader($loaderResolver);
    $this -> routeCollection = $delegatingLoader -> load('base.router.yaml');
  }
}
