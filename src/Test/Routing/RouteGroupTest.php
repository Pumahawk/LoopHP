<?php

namespace LoopHP\Test\Routing;

use PHPUnit\Framework\TestCase;
use LoopHP\Routing\Route;
use LoopHP\Routing\RouteGroup;
use LoopHP\ControllerData;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as SyRoute;

class RouteGroupTest extends TestCase {

  public function getControllerData() {
    return new ControllerData('controller', 'method');
  }

  public function getRoute($name = 'name', $pattern = '/pattern') {
    $controllerData = $this -> getControllerData();
    return new Route($name, $pattern, $controllerData);
  }

  public function testCreation() {
    $group = new RouteGroup('name', '/pattern');
    $this -> assertEquals('name', $group -> name());
    $this -> assertEquals('/pattern', $group -> pattern());
  }

  public function testAdd() {
    $route = $this -> getRoute();
    $group = new RouteGroup();
    $group -> add($route);
    $this -> assertEquals([
        'name' => $route
      ],
      $group -> all()
    );

    return $group;
  }

  /**
  * @depends testAdd
  */
  public function testRemove($group) {
    $routeExp = $this -> getRoute();
    $routeR = $group -> remove('name');

    $this -> assertEquals(
      array(),
      $group -> all()
    );

    $this -> assertEquals($routeExp, $routeR);
  }

  /**
  * @depends testAdd
  * @depends testRemove
  */
  public function testMultipleAdd() {
    $group = new RouteGroup();
    $group -> add($this -> getRoute('route1', '/pattern1'));
    $group -> add($this -> getRoute('route2', '/pattern2'));
    $group -> add($this -> getRoute('route3', '/pattern3'));

    $this -> assertEquals(
      [
        'route1' => $this -> getRoute('route1', '/pattern1'),
        'route2' => $this -> getRoute('route2', '/pattern2'),
        'route3' => $this -> getRoute('route3', '/pattern3')
      ],
      $group -> all()
    );

    return $group;
  }

  /**
  * @depends testMultipleAdd
  */
  public function testMultipleRemove($group) {
    $group -> remove('route2');
    $group -> remove('route1');

    $this -> assertEquals(
      [
        'route3' => $this -> getRoute('route3', '/pattern3')
      ],
      $group -> all()
    );

    return $group;
  }

  /**
  * @depends testMultipleRemove
  */
  public function testAddGroup($group) {
    $gr = new RouteGroup('group', '/group');
    $gr -> add($this -> getRoute('route1', '/path1'));
    $gr -> add($this -> getRoute('route2', '/path2'));

    $group -> addGroup($gr);

    $this -> assertEquals(
      [
        'route3' => $this -> getRoute('route3', '/pattern3'),
        'group.route1' => $this -> getRoute('group.route1', '/group/path1'),
        'group.route2' => $this -> getRoute('group.route2', '/group/path2')
      ],
      $group -> all()
    );
  }

  public function testGetRouteCollection() {
    $routeCollection = new RouteCollection();
    $routeCollection -> add('b.route1', new SyRoute('/b/path1', ['controller' => 'controller@method']));
    $routeCollection -> add('b.route2', new SyRoute('/b/path2', ['controller' => 'controller@method']));
    $routeCollection -> add('b.group.route3', new SyRoute('/b/group/path3', ['controller' => 'controller@method']));
    $routeCollection -> add('b.group.route4', new SyRoute('/b/group/path4', ['controller' => 'controller@method']));

    $group = new RouteGroup('b', '/b');
    $group -> add($this -> getRoute('route1', '/path1'));
    $group -> add($this -> getRoute('route2', '/path2'));

    $group2 = new RouteGroup('group', '/group');
    $group2 -> add($this -> getRoute('route3', '/path3'));
    $group2 -> add($this -> getRoute('route4', '/path4'));

    $group -> addGroup($group2);

    $this -> assertEquals($routeCollection, $group -> getRouteCollection());
  }
}
