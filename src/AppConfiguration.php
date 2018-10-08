<?php

namespace LoopHP;
use Composer\Autoload\ClassLoader;

class AppConfiguration {
  protected $configuration;

  public function __construct() {
    $this -> configuration = [
      'app' => [
        'paths' => [
          'configurations' => [],
          'template' => '',
          'api' => []
        ],
        'composer' => null
      ]
    ];
  }
  public function getConfiguration() : array {
    return $this -> configuration;
  }
  public function addConfigurationPath(string $path) {
    $this -> configuration['app']['paths']['configurations'][] = $path;
    return $this;
  }
  public function getConfigurationPath() : array {
    return $this -> configuration['app']['paths']['configurations'];
  }
  public function setTemplate(string $path) {
    $this -> configuration['app']['paths']['template'] = $path;
    return $this;
  }
  public function getTemplate() : string {
    return $this -> configuration['app']['paths']['template'];
  }
  public function addApi(string $namespace, string $path) {
    $this -> configuration['app']['paths']['api'][$namespace] = $path;
    return $this;
  }
  public function getApi() : array {
    return $this -> configuration['app']['paths']['api'];
  }
  public function setComposer(ClassLoader $composer) {
    $this -> configuration['app']['composer'] = $composer;
    return $this;
  }
  public function getComposer() : ClassLoader {
    return $this -> configuration['app']['composer'];
  }
}
