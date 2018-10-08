<?php

namespace LoopHP\Controller;

use LoopHP\ControllerData;

use Symfony\Component\Templating\EngineInterface;

abstract class BaseController {
  protected $tEngine;
  protected $controllerData;

  public function __construct(EngineInterface $templateEngine,
                              ControllerData $controllerData) {
    $this -> setTemplateEngine($templateEngine);
    $this -> controllerData = $controllerData;
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
}
