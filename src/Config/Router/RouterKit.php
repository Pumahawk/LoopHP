<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/**
  * Classe contenente metodi di supporto per la gestione dei dati sui router.
*/

class RouterKit {
  
  /**
   * Converte un array in un RouteCollection
   * 
   * @param array $data Rappresentazione in array di un route collection
   * @param string $prefix Stringa da concatenare a tutti i prefissi dei vari router.
   * @return RouteCollection RouteCollection equivalente all'array passato.
   */
  public static function normalize(array $data, string $prefix = '') :  RouteCollection {
    // TODO Add Link functionality
    $routes = new RouteCollection();
    $data = $data['router'] ?? $data;
    foreach ($data as $key => $record) {
      if(isset($record['address'])) {
        $newCollection = RouterKit::normalize($record['address'], $record['pattern']);
        $newCollection -> addNamePrefix($record['name'].'.');
        $routes -> addCollection($newCollection);
      } else {
        $route = new Route($record['pattern'], $record['data'], $record['requirements'] ?? []);
        $routes -> add($record['name'], $route);
      }
    }
    $routes -> addPrefix($prefix);
    return $routes;
  }
}
