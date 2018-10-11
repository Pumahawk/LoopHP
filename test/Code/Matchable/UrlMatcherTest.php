<?php

namespace LoopHP\Test\Matchable;


use PHPUnit\Framework\TestCase;
use LoopHP\Matchable\UrlMatcher;
use LoopHP\ControllerData;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class UrlMatcherTest extends TestCase {
  public function testMatch() {
    $routes = new RouteCollection();
    $context = new RequestContext('/');
    $route = new Route('/url.html', [
      'controller' => 'controller@data'
    ]);
    $routes -> add('key', $route);
    $urlm = new UrlMatcher($routes, $context, '/url.html');
    $cd = $urlm -> match();
    $expected = new ControllerData('controller', 'data', array(
      'controller' => 'controller@data',
      '_route' => 'key'
    ));

    $this -> assertEquals(
      $expected,
      $cd
    );
  }
}
