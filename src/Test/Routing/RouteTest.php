<?php

namespace LoopHP\Test\Routing;

use PHPUnit\Framework\TestCase;
use LoopHP\Routing\Route;
use LoopHP\ControllerData;

class RouteTest extends TestCase {
  public function testCreation() {
    $route = new Route('name', '/pattern', new ControllerData('controller', 'method'));

    $this -> assertEquals('name', $route -> name());
    $this -> assertEquals('/pattern', $route -> pattern());
    $this -> assertEquals(new ControllerData('controller', 'method'), $route -> getControllerData());
  }
}
