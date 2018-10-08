<?php

namespace LoopHP;

class AppConfiguration {
  protected $configuration;

  public function __construct() {
    $this -> configuration = [
      'app' => [
        'paths' => [
          'configurations' => [],
          'controller' => [],
          'template' => [],
          'api' => []
        ]
      ]
    ];
  }
  public function getConfiguration() {
    return $this -> configuration;
  }
  public function addConfigurationPath(string $path) {
    $this -> configuration['app']['paths']['configurations'][] = $path;
    return $this;
  }
  public function getConfigurationPath() {
    return $this -> configuration['app']['paths']['configurations'];
  }
  public function addController(string $path) {
    $this -> configuration['app']['paths']['controller'][] = $path;
    return $this;
  }
  public function getController() {
    return $this -> configuration['app']['paths']['controller'];
  }
  public function addTemplate(string $path) {
    $this -> configuration['app']['paths']['template'][] = $path;
    return $this;
  }
  public function getTemplate() {
    return $this -> configuration['app']['paths']['template'];
  }
  public function addApi(string $path) {
    $this -> configuration['app']['paths']['api'][] = $path;
    return $this;
  }
  public function getApi() {
    return $this -> configuration['app']['paths']['api'];
  }
}
