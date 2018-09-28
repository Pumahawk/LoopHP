<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;

class PHPLoader extends FileLoader {

  public function load($resource, $type = null) {
    return require($this -> locator -> locate($resource));
  }
  public function supports($resource, $type = null) {
    return is_string($resource) && 'php' === pathinfo(
      $resource,
      PATHINFO_EXTENSION
    );
  }
}
