<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;

/**
 * Estensione del file loader di Symfony
 * Recupera il file php specificato come risorsa.
 */

class PHPLoader extends FileLoader {

  /**
   * @param string $resource
   */
  public function load($resource, $type = null) {
    return require($this -> locator -> locate($resource));
  }
  
  /**
   * Controlla che la risorsa abbia estensione php
   * 
   * @param string $resource
   */
  public function supports($resource, $type = null) {
    return is_string($resource) && 'php' === pathinfo(
      $resource,
      PATHINFO_EXTENSION
    );
  }
}
