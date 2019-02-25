<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\App;
use LoopHP\AppConfiguration;
use LoopHP\ControllerData;
use LoopHP\Routing\Route;
use LoopHP\Routing\RouteGroup;
use LoopHP\Config\Router\RouterKit;
use LoopHP\Matchable\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class RouterConfigurationTest extends TestCase {
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

    $app = new App($appConfiguration);

    $app -> setApiLoader();

    $this -> app = $app;
  }
  
  public function testMatchPage() {
    $this -> expectOutputString('page1');
    
    $this -> app -> setMatch(new UrlMatcher($this -> app -> loader() -> import('route/test2.route.yaml'), new RequestContext('/')));
    $this -> app -> getMatch() -> setUrl('/simple/use1');
    $this -> app -> start();
  }
}
