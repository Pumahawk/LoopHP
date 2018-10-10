<?php

namespace Controller;
use LoopHP\Controller\BaseController;

class ControllerRelation extends BaseController {
  public function hallo() {
    echo 'Hallo world!';
  }
  public function readConfig() {
    $config = $this -> config() -> load('configuration.yaml');
    echo $config['configuration']['type'];
  }
  public function renderTemplate() {
    echo $this -> tEngine() -> render('template.php');
  }
}
