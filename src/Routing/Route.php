<?php

namespace LoopHP\Routing;

use LoopHP\ControllerData;

/**
  * Facilita la configurazione dei Route per il funzionamento di LoopHP\App
  *
  * Route vine utilizzata durante la configurazione dei router per i matcher
  * assieme alla classe RouteGroup.
  * La class Route e' ispirata alla classe Route di Sinfony, infatti attraverso
  * l'attributo requirements e' possibile creare pattern variabili.
*/

class Route {
  protected $name;
  protected $pattern;
  protected $controllerData;
  protected $requirements;
  
  /**
    * @param string $name Nome del route, deve essere univoco per ogni route inserito in un RouteGroup o in un RoteCollection.
    * @param string $pattern Utilizzato dal matcher per la restituzione del ControllerData.
    * @param ControllerData $controllerData ControllerData restituito dal matcher.
    * @param array $requirements Array che impone dei limiti nei pattern dinamici. Vedi i Rotute di Symfony.
  */
  public function __construct($name, $pattern, $controllerData, array $requirements = array()) {
    $this -> name = $name;
    $this -> pattern = $pattern;
    $this -> controllerData = $controllerData;
    $this -> requirements = $requirements;
  }
  
  /**
    * Restituisce il nome.
    *
    * @return string
  */
  public function name() {
    return $this -> name;
  }

  /**
    * Restituisce il pattern.
    *
    * @return string
  */
  public function pattern() {
    return $this -> pattern;
  }

  /**
    * Restituisce il ControllerData impostato.
    *
    * @return ControllerData
  */
  public function getControllerData() {
    return $this -> controllerData;
  }
  
  /**
    * Setta i requirements.
    *
    * @param array $requirements 
    * @return Route Restituisce $this.
  */
  public function setRequirements(array $requirements) {
    $this -> requirements = $requirements;
    return $this;
  }
  
  /**
    * Restituisce i requirements dell'oggetto.
    *
    * @return array
  */
  public function getRequirements() {
    return $this -> requirements;
  }
}
