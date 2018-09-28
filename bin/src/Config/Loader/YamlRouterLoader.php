<?php

namespace LoopHP\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlRouterLoader extends FileLoader {

  public function load($resource, $type = null) {
    $data = Yaml::parse(file_get_contents($this -> locator -> locate($resource)));
    $data = $this -> normalize($data);
    return $data;
  }
  public function supports($resource, $type = null) {
    return is_string($resource) && 'yaml' === pathinfo(
      $resource,
      PATHINFO_EXTENSION
    );
  }
  public function normalize(array $data, string $pattern = '') : array {
    // TODO Add Link functionlity
    $finalData = array();
    foreach ($data as $key => $record) {
      if($record['type'] != 'address') {
        if($record['type'] == 'group') {
          foreach($this -> normalize($record['data'], $pattern.$record['pattern']) as $val) {
            $finalData[] = $val;
          }
        }
      } else {
        $data[$key]['pattern'] = $pattern.$record['pattern'];
        $finalData[] = $data[$key];
      }
    }

    return $finalData;
  }
}
