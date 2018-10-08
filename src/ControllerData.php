<?php

namespace LoopHP;

class ControllerData {
  protected $controller;
  protected $data;

  public function __construct(string $controller = '', array $data = array()) {
    $this -> controller = $controller;
    $this -> data = $data;
  }
  public function getController() : string {
    return $this -> controller;
  }
  public function setController(string $controller) {
    $this -> controller = $controller;
    return $this;
  }
  public function getData() : array {
    return $this -> data;
  }
  public function setData(array $data) {
    $this -> data = $data;
    return $this;
  }
}
