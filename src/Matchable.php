<?php

namespace LoopHP;

interface Matchable {
  public function match() : ControllerData;
}
