<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LoopHP\AppConfiguration;

class AppConfigurationTest extends TestCase {

  /**
  * @dataProvider getConfigurations
  */
  public function testSetConfiguration($configuration) {
    $postProcess['app'] = (new AppConfiguration($configuration)) -> getConfiguration();
    $this -> assertSame($configuration, $postProcess);
  }

  public function getConfigurations() {
    $configurations = array();

    $configurations[] = [[
      'app' => [
        'paths' => [
          'configurations' => [
            'configuration'  => 'path/to/configuration.file',
            'router' => 'path/to/router.file'
          ],
          'resources' => [
            'template' => [
              'path/to/template/directory'
            ]
          ],
          'source_code' => [
            'controller' => [
              'path/to/controller/directory'
            ],
            'api' => [
              'path/to/api/directory'
            ]
          ]
        ]
      ]
    ]];

    return $configurations;
  }
}
