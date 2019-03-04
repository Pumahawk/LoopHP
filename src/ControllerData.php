<?php

namespace LoopHP;

/**
 * Classe utilizatta dall'applicazione per il lancio del controller e del metodo associato.
 * Vengono memorizzate informazioni aggiuntive nell'attributo $data che possono essere
 * utilizzate successivamente dall'applicazione.
 */

class ControllerData {
  protected $controller;
  protected $method;
  protected $data;

  public function __construct(string $controller = '', string $method = '', array $data = array()) {
    $this -> controller = $controller;
    $this -> method = $method;
    $this -> data = $data;
  }
  public function getController() : string {
    return $this -> controller;
  }
  public function setController(string $controller) {
    $this -> controller = $controller;
    return $this;
  }
  public function getMethod() : string {
    return $this -> method;
  }
  public function setMethod(string $method) {
    $this -> method = $method;
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
