<?php

namespace LoopHP\Controller;

use LoopHP\ControllerData;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
  * Controllore utile per le richieste http/s.
  * 
  * Rispetto al controllre base viene creata la variabile che facilita la gestione
  * della richiesta del client.
*/

class HttpBaseController extends BaseController {
  protected $request;

  /**
    * @param EngineInterface $templateEngine template engine per la gestione dell'output.
    * @param ControllerData $controllerData informazioni sul metodo da lanciare e dati aggiuntivi.
    * @param LoaderInterface $loader loader per il caricamento dei file di configurazione.
  */
  public function __construct(EngineInterface $templateEngine,
                              ControllerData $controllerData,
                              LoaderInterface $loader) {
    parent::__construct($templateEngine, $controllerData, $loader);
    $this -> request = Request::createFromGlobals();
  }
  
  /**
    * @return Request le informazioni della richiesta del client.
  */
  public function request() {
    return $this -> request;
  }
}
