<?php

return [
  'router' => [
    [
      'name' => 'group',
      'pattern' => '/pathgroup',
      'address' => [
        [
          'name' => 'route',
          'pattern' => '/path',
          'data' => [
            'controller' => 'controller@action'
          ]
        ]
      ]
    ]
  ]
];
