<?php

namespace LoopHP\Test\Matchable;


use PHPUnit\Framework\TestCase;
use LoopHP\Matchable\StaticMatch;
use LoopHP\ControllerData;

class StaticMatchTest extends TestCase {
  public function testMatch() {
    $controllerData = new ControllerData(
      'controller',
      'method',
      [
        'data' => [
          'extraData' => 'value'
        ]
      ]
    );
    $match = new StaticMatch($controllerData);

    $this -> assertEquals(
      $controllerData,
      $match -> match()
    );
  }
}
