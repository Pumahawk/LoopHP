<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use LoopHP\Config\Loader\YamlRouterLoader;
use LoopHP\Test\Config\Router\RouterKitTest;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

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

  /**
  * @group router
  * @dataProvider getYamlDataFile
  */
  public function testProcessFile($expected, $path) {
    $routeLoader = new YamlRouterLoader(new FileLocator(__DIR__.'/../../../../resources/test/config/route'));
    $collection = $routeLoader -> load($path);
    $this -> assertEquals($expected,$collection);
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
  public function getYamlDataFile() {

    $collection0 = new RouteCollection();
    $collection0 -> add('group.route', new Route('/pathgroup/path', ['controller' => 'controller@action']));
    $path0 = 'test0.route.yaml';

    $data = [
      [$collection0, $path0]
    ];

    $collection1 = new RouteCollection();
    $collection1 -> add('group.route0', new Route('/pathgroup/path0', ['controller' => 'controller@action']));
    $collection1 -> add('group.route1', new Route('/pathgroup/path1', ['controller' => 'controller@action']));
    $path1 = 'test1.route.yaml';

    $data = [
      [$collection0, $path0],
      [$collection1, $path1]
    ];
    return $data;
  }
}
