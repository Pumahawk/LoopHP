<?php

namespace LoopHP\Config\Router;

class RouterKit {
  public function normalize(array $data, string $pattern = '') : array {
    // TODO Add Link functionality
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
