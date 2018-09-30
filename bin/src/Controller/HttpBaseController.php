<?php

namespace LoopHP\Controller;

use Symfony\Component\HttpFoundation\Request;

class HttpBaseController extends BaseController {
  protected $request;

  public function __construct(EngineInterface $templateEngine) {
    parent::__construct($templateEngine);
    $this -> request = Request::createFromGlobals();
  }
}
