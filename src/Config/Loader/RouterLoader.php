<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;
use LoopHP\Config\Router\RouterKit;
use LoopHP\Config\Router\RouterConfiguration;
use Symfony\Component\Routing\RouteCollection;

/**
 * Loader astratto che fornisce il metodo processRouterConfiguration in grado di 
 * semplificare la conversiona da una struttura dati generica ad un RouterCollection
 */

abstract class RouterLoader extends FileLoader {

  /**
   * @param string $resource Path della risorsa da prelevare.
   */
  public function load($resource, $type = null) {
    return $this -> processConfiguration(file_get_contents($this -> locator -> locate($resource)));
  }
  
  /**
   * 
   * @param array $routerData array di dati che rappresentano un RouteCollection
   * @return RouteCollection
   */
  public function processRouterConfiguration(array $routerData) {
    $process = new Processor();
    $process -> processConfiguration(new RouterConfiguration(), $routerData);
    $routerData = RouterKit::normalize($routerData);
    return $routerData;
  }
}
