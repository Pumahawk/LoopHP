<?php

namespace LoopHP;

class App {
  protected $match;
  protected $configuration
  public function __construct(AppConfiguration $configuration, Matchable $match) {
    $this -> configuration = $configuration;
    $this -> match = $match;
  }
  public function start() {
    // TODO
  }
  public function match() : Matchable {
    return $this -> match();
  }
}
