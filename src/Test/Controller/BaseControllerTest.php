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

class BaseControllerTest extends TestCase {
  public function getBaseController() {
    $enineInterface = new PhpEngine();
    $cData = new ControllerData();
    $loader = new DelegatingLoader();
    return new class($enineInterface, $cData, $loader) extends BaseController {};
  }
}
