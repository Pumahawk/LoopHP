<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\FileLoader;
use LoopHP\Config\Loader\PhpRouterLoader;
use LoopHP\Test\Config\Router\RouterKitTest;
use Symfony\Component\Config\FileLocator;

class PhpRouterLoaderTest extends TestCase {
  /**
  * @group router
  * @dataProvider getPhpData
  */
  public function testProcessPhpRouterConfiguration($expected, $data) {
    $resourceToArray = new RouterKitTest;
    $routeLoader = new PhpRouterLoader(new FileLocator(''));
    $collection = $routeLoader -> processPhpRouterConfiguration($data);
    $this -> assertEquals($expected, $resourceToArray -> routeCollectionToArray($collection));
  }

  public function getPhpData() {
    $phpText = array();
    //Configurazione 0
    $php = [
      'router' => [
        [
          'name' => 'route',
          'pattern' => '/path',
          'data' => [
            'controller' => ''
          ]
        ]
      ]
    ];
    $phpText[] = [
      [
        ['name' => 'route', 'path' => '/path']
      ],
      $php
    ];

    //Configurazione 1
    $php = [
      'router' => [
        [
          'name' => 'route0',
          'pattern' => '/path0',
          'data' => [
            'controller' => ''
          ]
        ],
        [
          'name' => 'route1',
          'pattern' => '/path1',
          'data' => [
            'controller' => ''
          ]
        ]
      ]
    ];
    $phpText[] = [
      [
        ['name' => 'route0', 'path' => '/path0'],
        ['name' => 'route1', 'path' => '/path1']
      ],
      $php
    ];

    //Configurazione 2
    $php = [
      'router' => [
        [
          'name' => 'group0',
          'pattern' => '/grouppath0',
          'address' => [
            [
              'name' => 'route0',
              'pattern' => '/path0',
              'data' => [
                'controller' => 'controller'
              ]
            ]
          ]
        ]
      ]
    ];
    $phpText[] = [
      [
        ['name' => 'group0.route0', 'path' => '/grouppath0/path0']
      ],
      $php
    ];

    //Configurazione 3
    $php = [
      'router' => [
        [
          'name' => 'group0',
          'pattern' => '/grouppath0',
          'address' => [
            [
              'name' => 'group1',
              'pattern' => '/grouppath1',
              'address' => [
                [
                  'name' => 'route0',
                  'pattern' => '/path0',
                  'data' => [
                    'controller' => 'controller'
                  ]
                ]
              ]
            ]
          ]
        ]
      ]
    ];
    $phpText[] = [
      [
        ['name' => 'group0.group1.route0', 'path' => '/grouppath0/grouppath1/path0']
      ],
      $php
    ];
/*
    //Configurazione 4
    $php = <<<YAML
router:
  - name: group0
    pattern: /grouppath0
    address:
      - name: group1
        pattern: /grouppath1
        address:
        - name: route0
          pattern: /path0
          data:
            controller: controller
        - name: route1
          pattern: /path1
          data:
            controller: controller


YAML;
    $phpText[] = [
      [
        ['name' => 'group0.group1.route0', 'path' => '/grouppath0/grouppath1/path0'],
        ['name' => 'group0.group1.route1', 'path' => '/grouppath0/grouppath1/path1']
      ],
      $php
    ];
*/
    return $phpText;
  }
}
