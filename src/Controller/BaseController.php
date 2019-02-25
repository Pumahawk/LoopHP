<?php

namespace LoopHP\Controller;

use LoopHP\ControllerData;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
  * Classe base per tutti i controllori
  *
  * E' consigliato estendere tutti i controllori con questa classe in quanto
  * fornisce un insieme di metodi utili alla gestione delle richieste.
  * Metodi forniti utili:
  *
  * tEngine(): Permette l'accesso al template engine.
  * cData(): Permette l'accesso a dati forniti dal matcher.
  * config(): Permette l'accesso al loader dei file di configurazione.
  * params(): Permette l'accesso ai dati restituiti dal matcher in maniera ordinata.
*/

abstract class BaseController {
  protected $tEngine;
  protected $controllerData;
  protected $loader;

  /**
    * @param EngineInterface $templateEngine template engine per la gestione dell'output.
    * @param ControllerData $controllerData informazioni sul metodo da lanciare e dati aggiuntivi.
    * @param LoaderInterface $loader loader per il caricamento dei file di configurazione.
  */

  public function __construct(EngineInterface $templateEngine,
                              ControllerData $controllerData,
                              LoaderInterface $loader) {
    $this -> setTemplateEngine($templateEngine);
    $this -> controllerData = $controllerData;
    $this -> loader = $loader;
  }
  
  /**
    * Setta il templateEngine dell'oggetto.
    *
    * @param EngineInterface nuove template engine da sostituire.
    * @return void
  */

  public function setTemplateEngine(EngineInterface $templateEngine) {
    $this -> tEngine = $templateEngine;
  }

  /**
    * Accesso al template engine associato al controllore.
    * 
    * @return EngineInterface
  */
  public function tEngine() : EngineInterface {
    return $this -> tEngine;
  }

  /**
    * Accesso al controller data associato al controllore.
    *
    * @return ControllerData
  */
  public function cData() : ControllerData {
    return $this -> controllerData;
  }

  /**
   * Accesso al loader che facilita la gestione dei file di configurazione.
   *
   * @return LoaderInterface
  */
  public function config() : LoaderInterface {
    return $this -> loader;
  }

  /**
    * Accesso diretto alle variabili presenti nei dati del ControllerData in maniera facilitata
    * @return mixed
  */
  public function params(string ... $keys) {
    $value = $this -> controllerData -> getData();
    foreach ($keys as $key) {
      $value = $value[$key];
    }
    return $value;
  }
}
