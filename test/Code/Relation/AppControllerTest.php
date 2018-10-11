<?php


namespace LoopHP\Test\Relation;

use PHPUnit\Framework\TestCase;
use LoopHP\App;
use LoopHP\ControllerData;
use LoopHP\AppConfiguration;
use LoopHP\Matchable;

class AppControllerTest extends TestCase {
  public function getConfiguration() {
    $conf = new AppConfiguration();
    $conf
      -> setTemplate(__DIR__.'/../../../resources/test/views')
      -> addConfigurationPath(__DIR__.'/../../../resources/test/config')
      -> setComposer(require(__DIR__.'/../../../vendor/autoload.php'))
      -> addApi('Controller\\', __DIR__.'/../../../resources/test/controller');
    return $conf;
  }
  public function getMachable(string $method, array $data = array()) {
    return new class($method, $data) implements Matchable {
      protected $data;
      public function __construct(string $method, array $data = array()) {
        $this -> data = new ControllerData('Controller\\ControllerRelation', $method, $data);
      }
      public function match() : ControllerData {
        return $this -> data;
      }
    };
  }
  public function testExecuteController() {
    $this -> expectOutputString('Hallo world!');
    $match = $this -> getMachable('hallo');
    $appc = $this -> getConfiguration();

    $app = new App($appc, $match);
    $app -> setApiLoader();
    $app -> start();
  }
  public function testReadConfigurationFile() {
    $this -> expectOutputString('yaml');
    $match = $this -> getMachable('readConfig');
    $appc = $this -> getConfiguration();

    $app = new App($appc, $match);
    $app -> setApiLoader();
    $app -> start();
  }
  public function testRenderTemplate() {
    $this -> expectOutputString('ciao mondo!');
    $match = $this -> getMachable('renderTemplate');
    $appc = $this -> getConfiguration();

    $app = new App($appc, $match);
    $app -> setApiLoader();
    $app -> start();
  }
  public function testPassingData() {
    $this -> expectOutputString('dato');
    $match = $this -> getMachable('readData', ['keydata' => 'dato']);
    $appc = $this -> getConfiguration();

    $app = new App($appc, $match);
    $app -> setApiLoader();
    $app -> start();
  }
}
