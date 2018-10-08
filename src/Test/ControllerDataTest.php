<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\ControllerData;

class ControllerDataTest extends TestCase {
  public function testConstruct() {
    $cd = new ControllerData(
      'Controller@controller',
      [
        'id' => 1234
      ]
    );

    $this -> assertEquals(
      'Controller@controller',
      $cd -> getController()
    );

    $this -> assertEquals(
      [
        'id' => 1234
      ],
      $cd -> getData()
    );
  }

  public function testGetController() {
    $cd = new ControllerData('controller');
    $this -> assertEquals(
      'controller',
      $cd -> getController()
    );
  }
  /**
  * @depends testGetController
  */
  public function testSetController() {
    $cd = new ControllerData();
    $cd -> setController('controller');
    $this -> assertEquals(
      'controller',
      $cd -> getController()
    );
  }
  public function testGetData() {
    $cd = new ControllerData('', [
      'id' => 12345
    ]);
    $this -> assertEquals(
      [
        'id' => 12345
      ],
      $cd -> getData()
    );
  }

  /**
  * @depends testGetData
  */
  public function testSetData() {
    $cd = new ControllerData();
    $cd -> setData(
      [
        'id' => 12345
      ]
    );
    $this -> assertEquals(
      [
        'id' => 12345
      ],
      $cd -> getData()
    );
  }
}
