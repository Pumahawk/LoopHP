<?php

namespace LoopHP\Routing;

use LoopHP\ControllerData;

class Route {
  protected $name;
  protected $pattern;
  protected $controllerData;

  public function __construct($name, $pattern, $controllerData) {
    $this -> name = $name;
    $this -> pattern = $pattern;
    $this -> controllerData = $controllerData;
  }

  public function name() {
    return $this -> name;
  }

  public function pattern() {
    return $this -> pattern;
  }

  public function getControllerData() {
    return $this -> controllerData;
  }

}
