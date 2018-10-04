<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Processor;

class RouterConfiguration  implements ConfigurationInterface {

  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();

    $patternNode = new ScalarNodeDefinition('pattern');
    $dataNode = new ArrayNodeDefinition('data');
    $dataNode -> children()
      -> scalarNode('controller');
    $addressNode = new ArrayNodeDefinition('address');
    $addressNode
      -> arrayPrototype()
        -> append($patternNode)
        -> append(new ScalarNodeDefinition('name'))
        -> append($dataNode)
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
    -> append($addressNode);
    return $treeBuilder;
  }
}
