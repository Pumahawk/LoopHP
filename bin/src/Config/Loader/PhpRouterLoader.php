<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use LoopHP\Config\Router\RouterKit;

class PHPRouterLoader extends FileLoader {

  public function load($resource, $type = null) {
    $routerKit = new RouterKit();
    $data = require($this -> locator -> locate($resource));
    $data = $routerKit -> normalize($data);
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
