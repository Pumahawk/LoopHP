<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LoopHP\Config\Router\RouterConfiguration;
use Symfony\Component\Config\Definition\Processor;

final class RouterConfigurationTest extends TestCase
{
    /**
    * @group router
    * @dataProvider routerValidConfigurationList
    * @doesNotPerformAssertions
    */
    public function testProcessValidConfiguration($configuration): void
    {
        $routerConf = new RouterConfiguration();
        $pro = new Processor();
        $pro -> processConfiguration($routerConf, $configuration);
    }

    public function routerValidConfigurationList() {
      $configurationList = array();

      //Configuration 0
      $configurationList[] = [[
        'router' => [
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'data' => [
              'controller' => 'controller'
            ]
          ]
        ]
      ]];

      //Configuration 1
      $configurationList[] = [[
        'router' => [
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'data' => [
              'controller' => 'controller'
            ]
          ],
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'data' => [
              'controller' => 'controller'
            ]
          ]
        ]
      ]];

      //Configuration 2
      $configurationList[] = [[
        'router' => [
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'address' => [
              [
                'pattern' => 'pattern',
                'name' => 'name',
                'data' => [
                  'controller' => 'controller'
                ]
              ]
            ]
          ]
        ]
      ]];

      //Configuration 3
      $configurationList[] = [[
        'router' => [
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'address' => [
              [
                'pattern' => 'pattern',
                'name' => 'name',
                'address' => [
                  [
                    'pattern' => 'pattern',
                    'name' => 'name',
                    'data' => [
                      'controller' => 'controller'
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ]];

      //Configuration 3
      $configurationList[] = [[
        'router' => [
          [
            'pattern' => 'pattern',
            'name' => 'name',
            'address' => [
              [
                'pattern' => 'pattern',
                'name' => 'name',
                'address' => [
                  [
                    'pattern' => 'pattern',
                    'name' => 'name',
                    'data' => [
                      'controller' => 'controller'
                    ]
                  ],
                  [
                    'pattern' => 'pattern',
                    'name' => 'name',
                    'data' => [
                      'controller' => 'controller'
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ]];

      return $configurationList;
    }
}
