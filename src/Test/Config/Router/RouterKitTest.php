<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LoopHP\Config\Router\RouterKit;

final class RouterKitTest extends TestCase {

  /**
  * @group router
  * @dataProvider getDataNormalizeTest
  */
  public function testNormalize($expected, $data) {
    $routerKit = new RouterKit();
    $routeCollection = $routerKit -> normalize($data);

  }

  public function getDataNormalizeTest() {
    $data = array();
    $data[] = [
      [

      ],
      [

      ]
    ];
    return $data;
  }
}
