<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\FileLoader;
use LoopHP\Config\Loader\YamlRouterLoader;
use LoopHP\Test\Config\Router\RouterKitTest;
use Symfony\Component\Config\FileLocator;

class YamlRouterLoaderTest extends TestCase {
  /**
  * @group router
  * @dataProvider getYamlText
  */
  public function testProcessYamlRouterConfiguration($expected, $yamlText) {
    $resourceToArray = new RouterKitTest;
    $routeLoader = new YamlRouterLoader(new FileLocator(''));
    $collection = $routeLoader -> processYamlRouterConfiguration($yamlText);
    $this -> assertEquals($expected, $resourceToArray -> routeCollectionToArray($collection));
  }

  public function getYamlText() {
    $yamlText = array();
    //Configurazione 0
    $yaml = <<<YAML
router:
  - name: route
    pattern: /path
    data:
      controller: controller
YAML;
    $yamlText[] = [
      [
        ['name' => 'route', 'path' => '/path']
      ],
      $yaml
    ];

    //Configurazione 1
    $yaml = <<<YAML
router:
  - name: route0
    pattern: /path0
    data:
      controller: controller
  - name: route1
    pattern: /path1
    data:
      controller: controller
YAML;
    $yamlText[] = [
      [
        ['name' => 'route0', 'path' => '/path0'],
        ['name' => 'route1', 'path' => '/path1']
      ],
      $yaml
    ];

    //Configurazione 2
    $yaml = <<<YAML
router:
  - name: group0
    pattern: /grouppath0
    address:
      - name: route0
        pattern: /path0
        data:
          controller: controller


YAML;
    $yamlText[] = [
      [
        ['name' => 'group0.route0', 'path' => '/grouppath0/path0']
      ],
      $yaml
    ];

    //Configurazione 3
    $yaml = <<<YAML
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


YAML;
    $yamlText[] = [
      [
        ['name' => 'group0.group1.route0', 'path' => '/grouppath0/grouppath1/path0']
      ],
      $yaml
    ];

    //Configurazione 4
    $yaml = <<<YAML
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
    $yamlText[] = [
      [
        ['name' => 'group0.group1.route0', 'path' => '/grouppath0/grouppath1/path0'],
        ['name' => 'group0.group1.route1', 'path' => '/grouppath0/grouppath1/path1']
      ],
      $yaml
    ];

    return $yamlText;
  }
}
