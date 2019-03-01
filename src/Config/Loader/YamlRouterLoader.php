<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Routing\RouteCollection;

/**
 * Permette di caricare file .route.yaml e restituire il un RouteCollection equivalente.
 */

class YamlRouterLoader extends RouterLoader {
  
  /**
   * @param string $resource Percorso della risorsa.
   */
  public function load($resource, $type = null) {
    return $this -> processYamlRouterConfiguration(file_get_contents($this -> locator -> locate($resource)));
  }
  
  /**
   * Processa una stringa in formato yaml e restituisce l'oggetto equivalente di
   * tipo RouteCollection
   * 
   * @param string $yamlText Stringa in formato yaml
   * @return RouteCollection
   */
  public function processYamlRouterConfiguration(string $yamlText) {
    $data = Yaml::parse($yamlText);
    $data = $this -> processRouterConfiguration($data);
    return $data;
  }
  
  /**
   * Controlla che l'estensione sia .route.yaml
   * @param string $resource
   * @return boolean
   */
  public function supports($resource, $type = null) {
    $pathinfo = pathinfo($resource);
    $ext1 = $pathinfo['extension'];
    $ext2 = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    return is_string($resource) && 'yaml' === $ext1 && 'route' === $ext2;
  }
}
