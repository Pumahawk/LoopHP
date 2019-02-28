<?php

namespace LoopHP\Routing;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as SyRoute;

/**
  * Rappresenta un gruppo di route.
  * 
  * Facilita la creazione di gruppi di route e la conversione in un 
  * RouteCollection di Symfony.
  * RouteGroup ha 2 variabili importanti.
  * name e pattern. Entrambi vengono concatenati ai router al loro interno 
  * quando vengono convertiti nel RouteCollection di Symfony.
*/

class RouteGroup {
  protected $name;
  protected $pattern;
  protected $routeList;
  
  /**
    * @param string $name id che permette di identificare tutti i route nel gruppo concatenandolo con il loro name.
    * @param string $pattern pattern concatentato a tutti i pattern dei router nel gruppo.
  */
  public function __construct($name = '', $pattern = '') {
    $this -> routeList = array();
    $this -> name = $name;
    $this -> pattern = $pattern;
  }
  
  /**
    * Restituisce il pattern del gruppo.
    *
    * @return string
  */
  public function pattern() {
    return $this -> pattern;
  }

  /**
    * Restituisce il nome del gruppo.
    * 
    * @return string
  */
  public function name() {
    return $this -> name;
  }

  /**
    * Aggiunge un Route al gruppo.
    *
    * @param Route $route Route da aggiungere al gruppo.
  */
  public function add(Route $route) {
    $this -> routeList[$route -> name()] = $route;
  }

  /**
    * Rimuove un route dal gruppo.
    *
    * @param string @name Identificatore del route da rimuovere.
    * @return Route Route rimosso dal gruppo se presente, sltrimenti null
  */
  public function remove(string $name) {
    if(isset($this -> routeList[$name])) {
      $route = $this -> routeList[$name];
      unset($this -> routeList[$name]);
      return $route;
    } else {
      return null;
    }
  }

  /**
    * Restituisce un route presente nel gruppo in base al nome.
    *
    * @param string @name Identificativo del route da prendere.
    * @return Route Restituisce il route trovato se esiste altrimenti null.
  */
  public function get(string $name) {
    if(isset($this -> routeList[$name])) {
      return $this -> routeList[$name];
    } else {
      return null;
    }
  }
  
  /**
    * Restituisce tutti i Route presenti nel gruppo.
    * 
    * @return array Ritorna una array di Route.
  */
  public function all() {
    return $this -> routeList;
  }

  /**
    * Converte il gruppo in un RouteCollection di Sumfony
    *
    * @return RouteCollection
  */
  public function getRouteCollection() {
    $routeCollection = new RouteCollection();
    foreach ($this -> routeList as $name => $route) {
      $data = $route -> getControllerData() -> getData();
      $data['controller'] = $route -> getControllerData() -> getController() . '@' . $route -> getControllerData() -> getMethod();
      $syRoute = new SyRoute($route -> pattern(), $data, $route -> getRequirements());
      $routeCollection -> add($name, $syRoute);
    }
    $routeCollection -> addNamePrefix($this -> name . '.');
    $routeCollection -> addPrefix($this -> pattern);

    return $routeCollection;
  }
  
  /**
    * Aggiunge i route del gruppo aggiunto al gruppo.
    * Tutti i route presenti nel gruppo vengono ricreati concatenando 
    * correttamente il nome e pattern del gruppo con il nome e pattern dei route.
    *
    * @param RouteGroup $group Gruppo da aggiungere.
  */
  public function addGroup(RouteGroup $group) {
    $groupPattern = $group -> pattern();
    $groupName = $group -> name();
    $list = $group -> all();

    foreach ($list as $name => $route) {
      $this -> add(new Route($groupName . '.' . $route -> name(), $groupPattern . $route -> pattern(), $route -> getControllerData(), $route -> getRequirements()));
    }
  }
}
