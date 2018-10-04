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

  public function __construct(AppConfiguration $configuration, $context) {
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

  public function process(strign $request){
    $this -> init();
  }

  public function init() {
    //init loader application
  }

  public function controllerExecution($data) {
  }
}
