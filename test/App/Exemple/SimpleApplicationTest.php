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

class SimpleApplicationTest extends TestCase {
  
  /**
    * @doesNotPerformAssertions
  */
  public function testConfigurationApp() {
    $baseDataTestPath = 'resources/test/exemple/simple_application';
    
    $appConfig = new AppConfiguration();
    $appConfig 
      -> setTemplate($baseDataTestPath.'/template')
      -> addApi('C\\', $baseDataTestPath.'/controller')
      -> setComposer(require(__DIR__.'/../../../vendor/autoload.php'));
      
    $routeGroup = new RouteGroup();
    $routeGroup -> add(new Route('home', '/home', new ControllerData('C\\Controller', 'home')));
    $routeGroup -> add(new Route('homeTemplate', '/homeTemplate', new ControllerData('C\\Controller', 'homeTemplate')));
    $routeGroup -> add(new Route('productTemplate', '/productTemplate', new ControllerData('C\\Controller', 'productTemplate')));
    
    $matcher = new UrlMatcher($routeGroup -> getRouteCollection(), new RequestContext('/'));
    
    $app = new App($appConfig, $matcher);
    $app -> setApiLoader();
    
    return $app;
  }
  
  /**
    * @depends testConfigurationApp
  */
  public function testHomeAccess($app) {
    $this -> expectOutputString('Welcome to my home!');
    $app -> getMatch() -> setUrl('/home');
    $app -> start();
  }
  
  /**
    * @depends testConfigurationApp
  */
  public function testHomeTemplateAccess($app) {
    $this -> expectOutputString('Home page template');
    $app -> getMatch() -> setUrl('/homeTemplate');
    $app -> start();
  }
  
  /**
    * @depends testConfigurationApp
  */
  public function testProductTemplateAccess($app) {
    
    $this -> expectOutputString(file_get_contents(__DIR__.'/../../../resources/test/exemple/simple_application/out/productTemplate.html'));
    $app -> getMatch() -> setUrl('/productTemplate');
    $app -> start();
  }
}