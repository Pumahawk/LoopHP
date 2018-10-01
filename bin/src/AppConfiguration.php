<?php

namespace LoopHP;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;

class AppConfiguration  implements ConfigurationInterface {
  protected $configuration;

  public function getConfiguration() : array{
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
    $this -> setConfiguration($configuration);
  }

  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('app');

    $rootNode
    -> children()
      -> arrayNode('paths')
        -> children()
          -> arrayNode('configurations')
            -> children()
              -> scalarNode('configuration') -> end()
              -> scalarNode('router') -> end()
            -> end()
          -> end()
          -> arrayNode('resources')
            -> children()
              -> arrayNode('template')
                -> scalarPrototype() -> end()
              -> end()
            -> end()
          -> end()
          -> arrayNode('source_code')
            -> children()
              -> arrayNode('controller')
                -> scalarPrototype() -> end()
              -> end()
              -> arrayNode('api')
                -> scalarPrototype() -> end()
              -> end()
            -> end()
          -> end()
        -> end()
      -> end();



    return $treeBuilder;
  }
}
