<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Routing\RouteCollection;

/**
  * Permette di accedere alle risorse contenute nei file .router.php
  * Se il file rispetta la sintassi allora restituisce un RouteCollection di Symfony.
 */

class PHPRouterLoader extends RouterLoader {

  /**
    * @param string $resource Path del file .route.php
    * @return RouteCollection
   */
  public function load($resource, $type = null) {
    $data = require($this -> locator -> locate($resource));
    return $this -> processPhpRouterConfiguration($data);
  }
    
  /**
   * 
   * @param array $data Array che rispetta la sintassi per essere convertito in un RouteCollection.
   * @return RouteCollection
   */
  public function processPhpRouterConfiguration(array $data) {
    $data = $this -> processRouterConfiguration($data);
    return $data;
  }
  
  /**
   * @param string $resource Path della risorsa.
   * @return boolean Restituisce true se il loader e' in grado di aprire la risorsa.
   */
  public function supports($resource, $type = null) {
    $pathinfo = pathinfo($resource);
    $ext1 = $pathinfo['extension'];
    $ext2 = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    return is_string($resource) && 'php' === $ext1 && 'route' === $ext2;
  }
}
