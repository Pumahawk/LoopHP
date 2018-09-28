<?php

namespace LoopHP;

class App {
  protected $configuration;

  public function __construct(AppConfiguration $configuration) {
    $this -> configuration = $configuration;
  }

  public function setConfiguration(AppConfiguration $configuration) {
    $this -> configuration = $configuration;
  }

  public function getConfiguration() : AppConfiguration{
    return $this -> configuration;
  }

  function start(){
    // TODO
  }
}
