<?php
declare(strict_types=1);
namespace LoopHP\Test\Config\Router;


use PHPUnit\Framework\TestCase;
use LoopHP\Config\Router\RouterKit;
use Symfony\Component\Routing\RouteCollection;

final class RouterKitTest extends TestCase {

  /**
  * @group router
  * @dataProvider getDataNormalizeTest
  */
  public function testNormalize($expected, $data) {
    $routeCollection = RouterKit::normalize($data);
    $this -> assertEquals($expected, $this -> routeCollectionToArray($routeCollection));
  }

  public function getDataNormalizeTest() {
    $data = array();
    // Collection 0
    $data[] = [
      [
        ['name' => 'route1', 'path' => '/path1'],
        ['name' => 'route2', 'path' => '/path2']
      ],
      [
        'router' => [
          [
            'name' => 'route1',
            'pattern' => '/path1',
            'data' => [
              'controller' => ''
            ]
          ],
          [
            'name' => 'route2',
            'pattern' => '/path2',
            'data' => [
              'controller' => ''
            ]
          ]
        ]
      ]
    ];

    // Collection 1
    $data[] = [
      [
        ['name' => 'group.route1', 'path' => '/pathgroup/path1']
      ],
      [
        'router' => [
          [
            'name' => 'group',
            'pattern' => '/pathgroup',
            'address' => [
              [
                'name' => 'route1',
                'pattern' => 'path1',
                'data' => [
                  'controller' => ''
                ]
              ]
            ]
          ]
        ]
      ]
    ];

    // Collection 2
    $data[] = [
      [
        ['name' => 'route', 'path' => '/path'],
        ['name' => 'group.route1', 'path' => '/pathgroup/path1']
      ],
      [
        'router' => [
          [
            'name' => 'route',
            'pattern' => '/path',
            'data' => [
              'controller' => ''
            ]
          ],
          [
            'name' => 'group',
            'pattern' => '/pathgroup',
            'address' => [
              [
                'name' => 'route1',
                'pattern' => 'path1',
                'data' => [
                  'controller' => ''
                ]
              ]
            ]
          ]
        ]
      ]
    ];

    // Collection 3
    $data[] = [
      [
        ['name' => 'group.group1.route', 'path' => '/path/group/path']
      ],
      [
        'router' => [
          [
            'name' => 'group',
            'pattern' => '/path',
            'address' => [
              [
                'name' => 'group1',
                'pattern' => '/group',
                'address' => [
                  [
                    'name' => 'route',
                    'pattern' => '/path',
                    'data' => [
                      'controller' => ''
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ]
    ];

    // Collection 4
    $data[] = [
      [
        ['name' => 'group.group1.route', 'path' => '/path/group/path'],
        ['name' => 'group.group1.route1', 'path' => '/path/group/path1']
      ],
      [
        'router' => [
          [
            'name' => 'group',
            'pattern' => '/path',
            'address' => [
              [
                'name' => 'group1',
                'pattern' => '/group',
                'address' => [
                  [
                    'name' => 'route',
                    'pattern' => '/path',
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
              ]
            ]
          ]
        ]
      ]
    ];
    return $data;
  }

  public function routeCollectionToArray(RouteCollection $routerCollection) {
    $collection = array();
    foreach ($routerCollection -> all() as $k => $route) {
      $routeArray = array();
      $routeArray['path'] = $route -> getPath();
      $routeArray['name'] = $k;
      $collection[] = $routeArray;
    }
    return $collection;
  }
}
