<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/**
  * Classe contenente metodi di supporto per la gestione dei dati sui router.
*/

class RouterKit {
  public function normalize(array $data, string $prefix = '') :  RouteCollection {
    // TODO Add Link functionality
    $routes = new RouteCollection();
    $data = $data['router'] ?? $data;
    foreach ($data as $key => $record) {
      if(isset($record['address'])) {
        $newCollection = $this -> normalize($record['address'], $record['pattern']);
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
