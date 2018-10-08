<?php

namespace LoopHP\Test;

use PHPUnit\Framework\TestCase;
use LoopHP\AppConfiguration;

class AppConfigurationTest extends TestCase {
  public function getBaseConfigurationTest() {
    return [
      'app' => [
        'paths' => [
          'configurations' => [],
          'controller' => [],
          'template' => [],
          'api' => []
        ],
        'composer' => null
      ]
    ];
  }
  public function testContruct() {
    $conf = new AppConfiguration;
    $this -> assertEquals(
      $this -> getBaseConfigurationTest(),
      $conf -> getConfiguration()
    );
  }

  public function testAddConfiguration() {
    $expected = $this -> getBaseConfigurationTest();
    if(!isset($expected['app']['paths']['configurations'])) {
      throw new \Exception('Errore test. Variabile $expected["app"]["paths"]["configurations"]["configurations"] non definita.');
    }

    $expected['app']['paths']['configurations'][] = 'new/path/configuration';

    $conf = new AppConfiguration;
    $conf -> addConfigurationPath('new/path/configuration');

    $this -> assertEquals(
      $expected,
      $conf -> getConfiguration()
    );

  }

  public function testGetConfigurationPath() {
    $conf = new AppConfiguration;
    $expected = [
      '/path1',
      '/path2'
    ];
    $conf
      -> addConfigurationPath('/path1')
      -> addConfigurationPath('/path2');
    $this -> assertEquals(
      $expected,
      $conf -> getConfigurationPath()
    );
  }

  public function testAddController() {
    $expected = $this -> getBaseConfigurationTest();
    if(!isset($expected['app']['paths']['controller'])) {
      throw new \Exception('Errore test. Variabile $expected["app"]["paths"]["configurations"]["controller"] non definita.');
    }

    $expected['app']['paths']['controller'][] = 'new/path/controller';

    $conf = new AppConfiguration;
    $conf -> addController('new/path/controller');

    $this -> assertEquals(
      $expected,
      $conf -> getConfiguration()
    );

  }
  public function testGetController() {
    $conf = new AppConfiguration;
    $expected = [
      '/path1/controller',
      '/path2/controller'
    ];
    $conf
      -> addController('/path1/controller')
      -> addController('/path2/controller');
    $this -> assertEquals(
      $expected,
      $conf -> getController()
    );
  }
  public function testAddApi() {
    $expected = $this -> getBaseConfigurationTest();
    if(!isset($expected['app']['paths']['api'])) {
      throw new \Exception('Errore test. Variabile $expected["app"]["paths"]["configurations"]["api"] non definita.');
    }

    $expected['app']['paths']['api']['namespace'] = 'new/path/api';

    $conf = new AppConfiguration;
    $conf -> addApi('namespace', 'new/path/api');

    $this -> assertEquals(
      $expected,
      $conf -> getConfiguration()
    );

  }
  public function testGetApi() {
    $conf = new AppConfiguration;
    $expected = [
      'namespace1' => '/path1/api',
      'namespace2' => '/path2/api'
    ];
    $conf
      -> addApi('namespace1', '/path1/api')
      -> addApi('namespace2', '/path2/api');
    $this -> assertEquals(
      $expected,
      $conf -> getApi()
    );
  }
  public function testAddTemplate() {
    $expected = $this -> getBaseConfigurationTest();
    if(!isset($expected['app']['paths']['template'])) {
      throw new \Exception('Errore test. Variabile $expected["app"]["paths"]["configurations"]["template"] non definita.');
    }

    $expected['app']['paths']['template'][] = 'new/path/template';

    $conf = new AppConfiguration;
    $conf -> addTemplate('new/path/template');

    $this -> assertEquals(
      $expected,
      $conf -> getConfiguration()
    );

  }
  public function testGetTemplate() {
    $conf = new AppConfiguration;
    $expected = [
      '/path1/template',
      '/path2/template'
    ];
    $conf
      -> addTemplate('/path1/template')
      -> addTemplate('/path2/template');
    $this -> assertEquals(
      $expected,
      $conf -> getTemplate()
    );
  }
  public function testSetComposer() {
    $expected = $this -> getBaseConfigurationTest();
    if(!isset($expected['app']['paths']['template'])) {
      throw new \Exception('Errore test. Variabile $expected["app"]["paths"]["configurations"]["template"] non definita.');
    }
    $composer = require(__DIR__.'/../../vendor/autoload.php');
    $expected['app']['composer'] = $composer;

    $conf = new AppConfiguration;
    $conf -> setComposer($composer);

    $this -> assertEquals(
      $expected,
      $conf -> getConfiguration()
    );
  }
  public function testGetComposer() {
    $conf = new AppConfiguration;
    $expected = require(__DIR__.'/../../vendor/autoload.php');
    $conf -> setComposer($expected);
    $this -> assertEquals(
      $expected,
      $conf -> getComposer()
    );
  }
}
