<?php

namespace C;

use LoopHP\Controller\BaseController;

class Controller extends BaseController {
  public function home(){
    echo 'Welcome to my home!';
  }
  public function homeTemplate() {
    echo $this -> tEngine() -> render('home.php');
  }
  public function productTemplate() {
    $data = [
      'id' => '1234',
      'nome' => 'Asus Computer',
      'descrizione' => 'Testo descrizione.'
    ];
    echo $this -> tEngine() -> render('product.php', $data);
  }
  public function dinamicOutput() {
    $id = $this -> params('number');
    echo 'key: '.$id;
  }
}