<?php

namespace LoopHP\Matchable;

use LoopHP\Matchable;
use LoopHP\ControllerData;
use Symfony\Component\Routing\Matcher\UrlMatcher as UrlMatcherSymfony;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Restituisce un ControllerData sulla base di un match con dei RouteCollection,
 * un RequestContext e un url.
 * Questo Matcher si rivela particolamente indicato per la creazione di una pllicazione
 * che fa uso di Url, come una applicazione Web.
 */

class UrlMatcher implements Matchable {
  protected $collection;
  protected $context;
  protected $url;
  
  /**
   * Istanzia un oggetto settando le variabili opportune.
   * 
   * @param RouteCollection $collection
   * @param RequestContext $context
   * @param string $url
   */
  public function __construct(RouteCollection $collection, RequestContext $context, $url = '') {
    $this -> collection = $collection;
    $this -> context = $context;
    $this -> url = $url;
  }
  
  /**
   * Restituisce il ControlerData in base al RouteCollection e all'url inserito.
   * 
   * @return ControllerData
   */
  public function match() : ControllerData {
    $matcher = new UrlMatcherSymfony($this -> collection, $this -> context);
    $parameters = $matcher->match($this -> url);
    $controller = explode('@', $parameters['controller']);
    $cd = new ControllerData($controller[0], $controller[1], $parameters);
    return $cd;
  }
  
  /**
   * Setta l'url con cui fare il match
   * 
   * @param string $url
   */
  public function setUrl(string $url) {
    $this -> url = $url;
  }
  
  /**
   * Restituisce l'url inserito.
   * 
   * @return string
   */
  public function url() {
    return $this -> url;
  }
}
