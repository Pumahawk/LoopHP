<?php

namespace LoopHP\Matchable;

use LoopHP\Matchable;
use LoopHP\ControllerData;
use Symfony\Component\Routing\Matcher\UrlMatcher as UrlMatcherSymfony;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class UrlMatcher implements Matchable {
  protected $collection;
  protected $context;
  protected $url;
  public function __construct(RouteCollection $collection, RequestContext $context, $url = '') {
    $this -> collection = $collection;
    $this -> context = $context;
    $this -> url = $url;
  }
  public function match() : ControllerData {
    $matcher = new UrlMatcherSymfony($this -> collection, $this -> context);
    $parameters = $matcher->match($this -> url);
    $controller = explode('@', $parameters['controller']);
    $cd = new ControllerData($controller[0], $controller[1], $parameters['data']);
    return $cd;
  }
}
