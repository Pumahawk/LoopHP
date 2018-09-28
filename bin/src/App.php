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


class App {
  protected $match;
  protected $configuration;
  protected $context;

  public function __construct(AppConfiguration $configuration, string $match, $context) {
    $this -> configuration = $configuration;
    $this -> context = $context;
    $this -> match = $match;
  }

  public function setConfiguration(AppConfiguration $configuration) {
    $this -> configuration = $configuration;
  }

  public function getConfiguration() : AppConfiguration{
    return $this -> configuration;
  }

  function start(){ // TODO  da migliorare
    $configFileLocator = new FileLocator(array($this -> configuration -> getConfigRouterDirectory()));
    $loader = new DelegatingLoader(new LoaderResolver(array(
      new YamlRouterLoader($configFileLocator),
      new PhpRouterLoader($configFileLocator)
    )));

    $routes = $loader -> import('base.route.yaml');

    $match = new UrlMatcher($routes, $this -> context);
    $this -> controllerExecution($match -> match($this -> match));

  }

  function controllerExecution($data) { // TODO da migliorare
    $action = explode('@', $data['controller']);
    $controller = 'LoopHP\\App\\Controller\\'.$action[0].'Controller';
    $pr = $action[1].'Action';
    $totalController = $controller.'::'.$pr;
    $totalController();
  }
}
