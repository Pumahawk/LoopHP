<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Permetti di caricare i file .yaml e di convertitre il loro contenuto in un array
 * equivalente.
 */

class YamlLoader extends FileLoader {

  /**
   * 
   * @param string $resource Path del file da caricare.
   * @return array Array equivalente al contenuto del file yaml.
   */
  public function load($resource, $type = null) {
    return Yaml::parse(file_get_contents($this -> locator -> locate($resource)));
  }
  
  /**
   * Controlla che il path della risorsa finisca con yaml
   * 
   * @param string $resource
   * @return boolean
   */
  public function supports($resource, $type = null) {
    return is_string($resource) && 'yaml' === pathinfo(
      $resource,
      PATHINFO_EXTENSION
    );
  }
}
