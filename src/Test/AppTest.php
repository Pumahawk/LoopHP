<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\AppConfiguration;
use LoopHP\ControllerData;
use LoopHP\Matchable;
use LoopHP\App;
use Test\Api\TestApi;
use Symfony\Component\Routing\RouteCollection;

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
    $cd = new ControllerData('controller', 'method', [
      'dato1' => 'dato1'
    ]);
    $appc = new AppConfiguration();
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);

    $expected = new ControllerData('controller', 'method', [
      'dato1' => 'dato1'
    ]);
    $this -> assertEquals($expected, $app -> match());
  }
  public function testGetConfigLoader() {
    $cd = new ControllerData();
    $appc = new AppConfiguration();
    $appc -> addConfigurationPath(__DIR__.'/../../resources/test/config');
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $loader = $app -> getConfigLoader();
    $dataPHP = $loader -> load('configuration.php');
    $this -> assertEquals(
      [
        'configuration' => [
          'type' => 'php',
          'name' => 'LoopHP'
        ]
      ],
      $dataPHP
    );
    $dataYAML = $loader -> load('configuration.yaml');
    $this -> assertEquals(
      [
        'configuration' => [
          'type' => 'yaml',
          'name' => 'LoopHP'
        ]
      ],
      $dataYAML
    );
  }
  public function testSetApiLoader() {
    $cd = new ControllerData();
    $appc = new AppConfiguration();
    $appc -> addApi('Test\\Api\\', __DIR__.'/../../resources/test/api/');
    $appc -> setComposer(require(__DIR__.'/../../vendor/autoload.php'));
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $app -> setApiLoader();
    $ver = new TestApi();
    $this -> assertTrue($ver instanceof TestApi);
    $this -> assertEquals('test-api', $ver -> message());
  }
  public function testStart() {
    $this -> expectOutputString('ciao dal controller.');
    $cd = new ControllerData();
    $cd -> setController('Controller\\TestController');
    $cd -> setMethod('method');
    $appc = new AppConfiguration();
    $appc -> setTemplate(__DIR__.'/../../resources/test/view');
    $appc -> addConfigurationPath(__DIR__.'/../../resources/test/config');
    $appc -> addApi('Controller\\', __DIR__.'/../../resources/test/controller/');
    $appc -> setComposer(require(__DIR__.'/../../vendor/autoload.php'));
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $app -> setApiLoader();
    $app -> start();
  }
  public function testLoader() {
    $cd = new ControllerData();
    $appc = new AppConfiguration();
    $appc -> addConfigurationPath( __DIR__.'/../../resources/test/config');
    $appc -> setComposer(require(__DIR__.'/../../vendor/autoload.php'));
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $loader = $app -> loader();
    $data = $loader -> load('configuration.php');
    $this -> assertEquals(
      [
        'configuration' => [
          'type' => 'php',
          'name' => 'LoopHP'
        ]
      ],
      $data,
      "Impossibile leggere file di configurazione di tipo PHP"
    );
    $data = $loader -> load('configuration.yaml');
    $this -> assertEquals(
      [
        'configuration' => [
          'type' => 'yaml',
          'name' => 'LoopHP'
        ]
      ],
      $data,
      "Impossibile leggere file di configurazione di tipo YAML"
    );
    $data = $loader -> load('route/test0.route.yaml');
    $this -> assertInstanceOf(RouteCollection::class, $data);
  }

  public function testTemplateEngine() {
    $cd = new ControllerData();
    $appc = new AppConfiguration();
    $appc -> setTemplate(__DIR__.'/../../resources/test/views');
    $matchable = $this -> getMachable($cd);
    $app = new App($appc, $matchable);
    $outTemplate = $app -> template() -> render('template.php');

    $this -> assertEquals('ciao mondo!', $outTemplate);
  }
}
