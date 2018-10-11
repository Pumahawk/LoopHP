<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\App;
use LoopHP\AppConfiguration;
use LoopHP\ControllerData;
use LoopHP\Routing\Route;
use LoopHP\Routing\RouteGroup;
use LoopHP\Matchable\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class SimpleUseTest extends TestCase {
  public $app;

  /**
  * @before
  */
  public function basicConfigurationApp() {
    $appConfiguration = new AppConfiguration();
    $appConfiguration
      -> setTemplate(__DIR__.'/../../resources/test/view')
      -> addConfigurationPath(__DIR__.'/../../resources/test/config')
      -> setComposer(require(__DIR__.'/../../vendor/autoload.php'))
      -> addApi('Controller\\', __DIR__.'/../../resources/test/controller/simple');

    $routeCollection = new RouteGroup();
    $routeCollection -> add(new Route('page1', '/page1', new ControllerData('Controller\\PageController', 'page1')));
    $routeCollection -> add(new Route('page2', '/page2', new ControllerData('Controller\\PageController', 'page2')));
    $routeCollection -> add(new Route('page3', '/page3/{value}', new ControllerData('Controller\\PageController', 'page3'),
      [
        'value' => '[0-9]*'
      ]
    ));

    $match = new UrlMatcher($routeCollection -> getRouteCollection(), new RequestContext('/'));

    $app = new App($appConfiguration, $match);

    $app -> setApiLoader();

    $this -> app = $app;
  }

  public function testSimpleMatch() {
    $this -> expectOutputString('page1');

    $this -> app -> getMatch() -> setUrl('/page1');
    $this -> app -> start();
  }

  public function testVariableRouting() {
    $this -> expectOutputString('123');

    $this -> app -> getMatch() -> setUrl('/page3/123');
    $this -> app -> start();
  }


  public function testVariableRoutingError() {
    $this->expectException(ResourceNotFoundException::class);

    $this -> app -> getMatch() -> setUrl('/page3/12s3');
    $this -> app -> start();
  }
}
