<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;
use LoopHP\Config\Router\RouterKit;
use LoopHP\Config\Router\RouterConfiguration;

class YamlRouterLoader extends RouterLoader {

  public function load($resource, $type = null) {
    return $this -> processConfiguration(file_get_contents($this -> locator -> locate($resource)));
  }
  public function processYamlRouterConfiguration(string $yamlText) {
    $data = Yaml::parse($yamlText);
    $data = $this -> processRouterConfiguration($data);
    return $data;
  }
  public function supports($resource, $type = null) {
    $routerKit = new RouterKit();
    $pathinfo = pathinfo($resource);
    $ext1 = $pathinfo['extension'];
    $ext2 = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    return is_string($resource) && 'yaml' === $ext1 && 'route' === $ext2;
  }
}
