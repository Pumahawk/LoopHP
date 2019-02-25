<?php

namespace LoopHP\Controller;

use Symfony\Component\HttpFoundation\Request;

class HttpBaseController extends BaseController {
  protected $request;

  public function __construct(EngineInterface $templateEngine,
                              ControllerData $controllerData,
                              LoaderInterface $loader) {
    parent::__construct($templateEngine, $controllerData, $loader);
    $this -> request = Request::createFromGlobals();
  }
}
