<?php

namespace LoopHP\Config\Router;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\ScalarNode;
use Symfony\Component\Config\Definition\Processor;

class RouterConfiguration  implements ConfigurationInterface {
  protected $configuration;

  public function getConfiguration() : array {
    return $this -> configuration;
  }
  public function setConfiguration(array $configuration) {
    $processor = new Processor();
    $this -> configuration = $processor->processConfiguration(
        $this,
        $configuration
    );
  }

  public function __construct(array $configuration) {
    //$this -> setConfiguration($configuration);
  }

  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();

    $arrayNode = $treeBuilder -> root('address');
    $arrayNode
    -> children()
      -> scalarNode('pattern') -> end()
      -> arrayNode('data')
        -> children()
          -> scalarNode('controller') -> end()
        -> end()
      -> end()
      -> variableNode('address')
        -> validate()
          -> always(function($data) use ($arrayNode){
            $node = $arrayNode -> getNode();
            var_dump($data);
            $data = $node -> normalize($data);
            $data = $node -> finalize($data);
          })
        -> end()
      -> end()
    -> end();
    
    return $treeBuilder;
  }
  public function validateRouter(ArrayNodeDefinition &$node) {
    $node
      -> children()
        -> scalarNode('val1') -> end()
        -> scalarNode('val2') -> end()
      -> end();
    $routerNode = $node -> children() -> arrayNode('router');
    $routerNode -> validate() -> always(function($val) use ($routerNode) {
      $routerNode -> finalize($val);
      return $val;
    });

  }
}
