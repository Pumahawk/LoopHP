<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

/**
  * Modello dei file di configurazione dei router.
  *
  * Implementata l'interfaccia ConfigurationInterface come spiegato nella documentazione
  * del componente Config di Symfony per riconoscere una truttura dati accettabile per 
  * per la creazione dei router.
*/

class RouterConfiguration  implements ConfigurationInterface {

  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();

    $patternNode = new ScalarNodeDefinition('pattern');
    $dataNode = new ArrayNodeDefinition('data');
    $dataNode -> children()
      -> scalarNode('controller');
    $requirementsNode = new ArrayNodeDefinition('requirements');
    $requirementsNode -> ignoreExtraKeys();
    $addressNode = new ArrayNodeDefinition('address');
    $addressNode
      -> arrayPrototype()
        -> append($patternNode)
        -> append(new ScalarNodeDefinition('name'))
        -> append($dataNode)
        -> append($requirementsNode)
        -> children()
          -> variableNode('address')
            -> validate() -> always(function($var) use ($addressNode){
              $node = $addressNode -> getNode();
              $node -> normalize($var);
              $node -> finalize($var);
              return $var;
            })
          -> end();


    $treeBuilder -> root('router') -> arrayPrototype()
    -> append($patternNode)
    -> append(new ScalarNodeDefinition('name'))
    -> append($dataNode)
    -> append($requirementsNode)
    -> append($addressNode);
    return $treeBuilder;
  }
}
