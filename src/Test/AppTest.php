<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\AppConfiguration;
use LoopHP\ControllerData;
use LoopHP\Matchable;
use LoopHP\App;

class AppTest extends TestCase {
  public function getMachable(ControllerData $data) {
    return new class($data) implements Matchable {
      protected $data;
      public function __construct(ControllerData $data) {
        $this -> data = $data;
      }
      public function match() : ControllerData {
        return $this -> data;
      }
    };
  }
  public function testMatch() {
    $cd = new ControllerData('controller', [
      'dato1' => 'dato1'
    ]);
    $appc = new AppConfiguration();
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);

    $expected = new ControllerData('controller', [
      'dato1' => 'dato1'
    ]);
    $this -> assertEquals($expected, $app -> match());
  }
  public function testGetConfigLoader() {
    $cd = new ControllerData();
    $appc = new AppConfiguration();
    $appc -> addConfigurationPath(__DIR__.'/../../resources/test');
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $loader = $app -> getConfigLoader();
    $data = $loader -> load('configuration.php');
    $this -> assertEquals(
      [
        'configuration' => [
          'name' => 'LoopHP'
        ]
      ],
      $data
    );
  }
}
