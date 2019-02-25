<?php

namespace Controller;
use LoopHP\Controller\BaseController;

class PageController extends BaseController {
  public function page1() {
    echo 'page1';
  }
  public function page2() {
    echo 'page2';
  }
  public function page3() {
    echo($this -> params('value'));
  }
  public function number() {
    echo($this -> params('number'));
  }
}
