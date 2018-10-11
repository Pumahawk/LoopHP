<?php

namespace LoopHP\Routing;

use LoopHP\ControllerData;

class Route {
  protected $name;
  protected $pattern;
  protected $controllerData;
  protected $requirements;

  public function __construct($name, $pattern, $controllerData, array $requirements = array()) {
    $this -> name = $name;
    $this -> pattern = $pattern;
    $this -> controllerData = $controllerData;
    $this -> requirements = $requirements;
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
  public function setRequirements(array $requirements) {
    $this -> requirements = $requirements;
    return $this;
  }
  public function getRequirements() {
    return $this -> requirements;
  }
}
