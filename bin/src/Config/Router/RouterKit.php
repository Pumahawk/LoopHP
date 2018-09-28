<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class RouterKit {
  public function normalize(array $data, string $prefix = '') :  RouteCollection {
    // TODO Add Link functionality
    $routes = new RouteCollection();
    foreach ($data as $key => $record) {
      if($record['type'] != 'address') {
        if($record['type'] == 'group') {
          $routes -> addCollection($this -> normalize($record['data'], $record['pattern']));
        }
      } else {
        $route = new Route($record['pattern'], $record['data']);
        $routes -> add($record['name'], $route);
      }
    }
    $routes -> addPrefix($prefix);
    return $routes;
  }
}
