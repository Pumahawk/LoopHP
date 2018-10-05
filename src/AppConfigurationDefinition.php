<?php

namespace LoopHP;

class AppConfigurationDefinition {
  protected $configuration;

  public function __construct() {
    $this -> configuration = [
      'app' => [
        'paths' => [
          'configurations' => [
            'configuration'  => '',
            'router' => ''
          ],
          'resources' => [
            'template' => []
          ],
          'source_code' => [
            'controller' => [],
            'api' => []
          ]
        ]
      ]
    ];
  }
public function getConfiguration() {
  return $this -> configuration;
}
  public function getAppConfiguration(){
    return new AppConfiguration($this -> configuration);
  }
  public function setConfigurationPath(string $configuration) : AppConfigurationDefinition {
    $this -> configuration['app']['paths']['configurations']['configuration'] = $configuration;
    return $this;
  }
  public function getConfigurationPath() : string {
    return $this -> configuration['app']['paths']['configurations']['configuration'];
  }
  public function setRouterPath(string $routerPath) {
    $this -> configuration['app']['paths']['configurations']['router'] = $routerPath;
    return $this;
  }
  public function addTemplate(string $template) {
    $this -> configuration['app']['paths']['resources']['template'][] = $template;
    return $this;
  }
  public function getTemplate() {
    return $this -> configuration['app']['paths']['resources']['template'];
  }
  public function addController(string $controller) {
    $this -> configuration['app']['paths']['source_code']['controller'][] = $controller;
    return $this;
  }
  public function getController() {
    return $this -> configuration['app']['paths']['source_code']['controller'];
  }
  public function addApi(string $api) {
    $this -> configuration['app']['paths']['source_code']['api'][] = $api;
    return $this;
  }
  public function getApi() {
    return $this -> configuration['app']['path']['source_code']['api'];
  }
}
