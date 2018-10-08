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
    $cData = new ControllerData();
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
}
