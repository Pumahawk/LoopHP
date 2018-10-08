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
    // TODO
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
}
