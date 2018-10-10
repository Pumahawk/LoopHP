<?php

namespace LoopHP\Controller;

use LoopHP\ControllerData;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Config\Loader\LoaderInterface;

abstract class BaseController {
  protected $tEngine;
  protected $controllerData;
  protected $loader;

  public function __construct(EngineInterface $templateEngine,
                              ControllerData $controllerData,
                              LoaderInterface $loader) {
    $this -> setTemplateEngine($templateEngine);
    $this -> controllerData = $controllerData;
    $this -> loader = $loader;
  }

  public function setTemplateEngine(EngineInterface $templateEngine) {
    $this -> tEngine = $templateEngine;
  }

  public function tEngine() : EngineInterface {
    return $this -> tEngine;
  }

  public function cData() : ControllerData {
    return $this -> controllerData;
  }

  public function config() {
    return $this -> loader;
  }

  public function params(string ... $keys) {
    $value = $this -> controllerData -> getData();
    foreach ($keys as $key) {
      $value = $value[$key];
    }
    return $value;
  }
}
