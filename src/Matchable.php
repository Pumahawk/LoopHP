<?php

namespace LoopHP;

/**
 * Interfaccia che caratterizza le classi che possono 
 * restituire un ControllerData tramire la funzione match
 */
interface Matchable {
  public function match() : ControllerData;
}
