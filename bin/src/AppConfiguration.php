<?php

namespace LoopHP;

abstract class AppConfiguration {
  protected $basePath;
  protected $pathConfigDirectory;
  protected $pathConfigRouterDirectory;

  public function __construct(string $basePath) {
    $this -> basePath = $basePath;
    $this -> pathConfigDirectory = $basePath.'/config';
    $this -> pathConfigRouterDirectory = $basePath.'/config/router';
  }

  public function getBasePath() : string {
    return $this -> basePath;
  }

  public function getPathConfigDirectory() : string {
    return $this -> pathConfigDirectory;
  }

  public function chetConfigRouterDirectory() : string {
    return $this -> pathConfigRouterDirectory;
  }
}
