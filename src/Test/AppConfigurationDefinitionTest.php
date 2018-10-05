<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LoopHP\AppConfigurationDefinition;

class AppConfigurationDefinitionTest extends TestCase {
  /**
  * @doesNotPerformAssertions
  */
  public function testCallSetMethods() {
    $appCongDef = new AppConfigurationDefinition();
    $appCongDef
      -> setConfigurationPath('path/to/configurations')
      -> setRouterPath('path/to/router')
      -> addTemplate('path/to/template')
      -> addController('path/to/controller')
      -> addApi('path/to/api');
  }

  /**
  * @depends testCallSetMethods
  */
  public function testSetMethods() {
    $appCongDef = new AppConfigurationDefinition();
    $appCongDef
      -> setConfigurationPath('path/to/configurations')
      -> setRouterPath('path/to/router')
      -> addTemplate('path/to/template0')
      -> addTemplate('path/to/template1')
      -> addController('path/to/controller0')
      -> addController('path/to/controller1')
      -> addApi('path/to/api0')
      -> addApi('path/to/api1');

    $expected = [
      'app' => [
        'paths' => [
          'configurations' => [
            'configuration'  => 'path/to/configurations',
            'router' => 'path/to/router'
          ],
          'resources' => [
            'template' => [
              'path/to/template0',
              'path/to/template1'
            ]
          ],
          'source_code' => [
            'controller' => [
              'path/to/controller0',
              'path/to/controller1'
            ],
            'api' => [
              'path/to/api0',
              'path/to/api1'
            ]
          ]
        ]
      ]
    ];

    $this -> assertEquals($expected, $appCongDef -> getConfiguration());
  }

  /**
  * @depends testSetMethods
  * @doesNotPerformAssertions
  */
  public function testGetAppConfigurationObject() {
    $appCongDef = new AppConfigurationDefinition();
    $appCongDef
      -> setConfigurationPath('path/to/configurations')
      -> setRouterPath('path/to/router')
      -> addTemplate('path/to/template')
      -> addController('path/to/controller')
      -> addApi('path/to/api');
    $appCongDef -> getAppConfiguration();
  }
}
