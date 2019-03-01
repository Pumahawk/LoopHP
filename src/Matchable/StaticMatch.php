<?php

namespace LoopHP\Matchable;

use LoopHP\Matchable;
use LoopHP\ControllerData;

/**
 * Matcher statico. Restituisce sempre il ControllerData passato
 * tra durante la costruzione dell'oggetto.
 * 
 * Utile durante la configurazione di una applicazione semplice che deve richiamare
 * soltanto un Controllore e un metodo.
 */

class StaticMatch implements Matchable {
  protected $controllerData;
  
  /**
   * Istazia lo StaticMatch memorizzando il ControllerData passato.
   * 
   * @param ControllerData $controllerData
   */
  public function __construct(ControllerData $controllerData) {
    $this -> controllerData = $controllerData;
  }
  
  /**
   * Restituisce sempre il ControllerData passato durante la creazione dell'oggetto.
   * 
   * @return ControllerData
   */
  public function match() : ControllerData {
    return $this -> controllerData;
  }
}
