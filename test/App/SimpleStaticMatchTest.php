<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\App;
use LoopHP\AppConfiguration;
use LoopHP\Matchable\StaticMatch;
use LoopHP\ControllerData;

class SimpleStaticMatchTest extends TestCase {
  
  public function testInstanceStaticMatch() {
    $staticMatch = new StaticMatch(new ControllerData('Controller\\StaticController', 'staticMatch',
      array('key' => 'value', 'key2' => 'value2')
    ));
    $controllerData = $staticMatch -> match();
    $this -> assertInstanceOf(ControllerData::class, $controllerData);
    $this -> assertEquals('Controller\\StaticController', $controllerData -> getController());
    $this -> assertEquals('staticMatch', $controllerData -> getMethod());
    $this -> assertEquals(
      array('key' => 'value', 'key2' => 'value2'),
      $controllerData -> getData()
    );
    
    return $staticMatch;
  }
  
  /**
    * @depends testInstanceStaticMatch
    * @doesNotPerformAssertions
  */
  public function testStaticAppCreation($staticMatch) {
    
    $appConfiguration = new AppConfiguration();
    $appConfiguration 
      -> setComposer(require(__DIR__.'/../../vendor/autoload.php'))
      -> addApi('Controller\\', __DIR__.'/../../resources/test/controller/simple');
    
    $app = new App(
      $appConfiguration,
      $staticMatch
    );
    
    $app -> setApiLoader();
    
    return $app;
  }
  
  /**
    * @depends testStaticAppCreation
  */
  public function testExecuteStaticMatch($app) {
    $this -> expectOutputString('executeStaticMatch');
    $app -> start();
  }
}