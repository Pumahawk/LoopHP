<?php

namespace LoopHP\Controller;

use Symfony\Component\Templating\EngineInterface;

abstract class BaseController {
  protected $tEngine;

  public function __construct(EngineInterface $templateEngine) {
    $this -> setTemplateEngine($templateEngine);
  }

  public function setTemplateEngine(EngineInterface $templateEngine) {
    $this -> tEngine = $templateEngine;
  }

  public function tEngine() : EngineInterface {
    return $this -> tEngine;
  }
}
