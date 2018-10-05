<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;
use LoopHP\Config\Router\RouterKit;
use LoopHP\Config\Router\RouterConfiguration;

abstract class RouterLoader extends FileLoader {

  public function load($resource, $type = null) {
    return $this -> processConfiguration(file_get_contents($this -> locator -> locate($resource)));
  }

  public function processRouterConfiguration(array $routerData) {
    $process = new Processor();
    $routerKit = new RouterKit();
    $process -> processConfiguration(new RouterConfiguration(), $routerData);
    $routerData = $routerKit -> normalize($routerData);
    return $routerData;
  }
}
