<?php

namespace LoopHP;

use Symfony\Component\Routing\RouteCollection;

interface ControllableInterface {
  public function getController(RouteCollection $routeCollection);
}
