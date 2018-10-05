<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use LoopHP\Config\Router\RouterKit;

class PHPRouterLoader extends RouterLoader {

  public function load($resource, $type = null) {
    $data = require($this -> locator -> locate($resource));
    return $this -> processPhpRouterConfiguration($data);
  }

  public function processPhpRouterConfiguration(array $data) {
    $data = $this -> processRouterConfiguration($data);
    return $data;
  }
  public function supports($resource, $type = null) {
    $routerKit = new RouterKit();
    $pathinfo = pathinfo($resource);
    $ext1 = $pathinfo['extension'];
    $ext2 = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    return is_string($resource) && 'php' === $ext1 && 'route' === $ext2;
  }
}
