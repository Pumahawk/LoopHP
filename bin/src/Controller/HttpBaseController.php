<?php

namespace LoopHP\Controller;

use Symfony\Component\HttpFoundation\Request;

class HttpBaseController extends BaseController {
  protected $request;

  public function __construct() {
    $this -> request = Request::createFromGlobals();
  }
}
