<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlLoader extends FileLoader {

  public function load($resource, $type = null) {
    return Yaml::parse(file_get_contents($this -> locator -> locate($resource)));
  }
  public function supports($resource, $type = null) {
    return is_string($resource) && 'yaml' === pathinfo(
      $resource,
      PATHINFO_EXTENSION
    );
  }
}
