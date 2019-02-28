<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Yaml\Yaml;

class YamlRouterLoader extends RouterLoader {

  public function load($resource, $type = null) {
    return $this -> processYamlRouterConfiguration(file_get_contents($this -> locator -> locate($resource)));
  }
  public function processYamlRouterConfiguration(string $yamlText) {
    $data = Yaml::parse($yamlText);
    $data = $this -> processRouterConfiguration($data);
    return $data;
  }
  public function supports($resource, $type = null) {
    $pathinfo = pathinfo($resource);
    $ext1 = $pathinfo['extension'];
    $ext2 = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    return is_string($resource) && 'yaml' === $ext1 && 'route' === $ext2;
  }
}
