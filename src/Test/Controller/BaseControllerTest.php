<?php

namespace Test\Controller;

use LoopHP\Controller\BaseController;
use PHPUnit\Framework\TestCase;
use LoopHP\ControllerData;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Config\Loader\LoaderInterface;

use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Config\FileLocator;
use LoopHP\Config\Loader\PhpLoader;

class BaseControllerTest extends TestCase {
  public function getBaseController() {
    $filesystemLoader = new FilesystemLoader(__DIR__.'/../../../resources/test/views/%name%');
    $fileLocator = new FileLocator(__DIR__.'/../../../resources/test/config');
    $engineInterface = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    $cData = new ControllerData(
      'controller',
      'method',
      [
        'key0' => 'value0',
        'key1' => [
          'key2' => 'value2'
        ]
      ]
    );
    $loader = new PhpLoader($fileLocator);
    return new class($engineInterface, $cData, $loader) extends BaseController {

    };
  }
  public function testConstruct() {
    $this -> expectOutputString('ciao mondo!');

    $controller = $this -> getBaseController();
    echo $controller -> tEngine() -> render('template.php');

    $this -> assertSame(
      [
        'configuration' => [
          'type' => 'php',
          'name' => 'LoopHP'
        ]
      ],
      $controller -> config() -> load('configuration.php')
    );
  }

  public function testGetParams() {
    $controller = $this -> getBaseController();
    $value = $controller -> params();
    $this -> assertEquals(
      [
        'key0' => 'value0',
        'key1' => [
          'key2' => 'value2'
        ]
      ]
      , $value);
    $value = $controller -> params('key0');
    $this -> assertEquals('value0', $value);
    $value = $controller -> params('key1');
    $this -> assertEquals([
      'key2' => 'value2'
    ], $value);
    $value = $controller -> params('key1','key2');
    $this -> assertEquals('value2', $value);
  }
}
