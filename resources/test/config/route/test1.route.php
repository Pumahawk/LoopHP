<?php

return [
  'router' => [
    [
      'name' => 'group',
      'pattern' => '/pathgroup',
      'address' => [
        [
          'name' => 'route0',
          'pattern' => '/path0',
          'data' => [
            'controller' => 'controller@action'
          ]
        ],
        [
          'name' => 'route1',
          'pattern' => '/path1',
          'data' => [
            'controller' => 'controller@action'
          ]
        ]
      ]
    ]
  ]
];
