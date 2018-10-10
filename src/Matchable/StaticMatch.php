<?php

namespace LoopHP\Matchable;

use LoopHP\Matchable;
use LoopHP\ControllerData;

class StaticMatch implements Matchable {
  protected $controllerData;
  public function __construct(ControllerData $controllerData) {
    $this -> controllerData = $controllerData;
  }
  public function match() : ControllerData {
    return $this -> controllerData;
  }
}
