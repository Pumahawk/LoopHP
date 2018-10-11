<?php

namespace LoopHP\Routing;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as SyRoute;

class RouteGroup {
  protected $name;
  protected $pattern;
  protected $routeList;

  public function __construct($name = '', $pattern = '') {
    $this -> routeList = array();
    $this -> name = $name;
    $this -> pattern = $pattern;
  }

  public function pattern() {
    return $this -> pattern;
  }

  public function name() {
    return $this -> name;
  }

  public function add(Route $route) {
    $this -> routeList[$route -> name()] = $route;
  }

  public function remove(string $name) {
    if(isset($this -> routeList[$name])) {
      $route = $this -> routeList[$name];
      unset($this -> routeList[$name]);
      return $route;
    } else {
      return null;
    }
  }

  public function get(string $name) {
    if(isset($this -> routeList[$name])) {
      return $this -> routeList[$name];
    } else {
      return null;
    }
  }

  public function all() {
    return $this -> routeList;
  }

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

  public function addGroup(RouteGroup $group) {
    $groupPattern = $group -> pattern();
    $groupName = $group -> name();
    $list = $group -> all();

    foreach ($list as $name => $route) {
      $this -> add(new Route($groupName . '.' . $route -> name(), $groupPattern . $route -> pattern(), $route -> getControllerData(), $route -> getRequirements()));
    }
  }
}
