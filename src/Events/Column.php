<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class Column {

  use SerializesModels;

  protected function getParams(array $data) {
    $params = [];
    if (in_array($data['type'], [
     'bigInteger',
     'integer',
     'mediumInteger',
     'smallInteger',
     'tinyInteger'
    ])) {
      array_push($params, var_export((boolean) array_get($data, 'autoincrement', FALSE), TRUE));
      array_push($params, var_export((boolean) array_get($data, 'unsigned', FALSE), TRUE));
    } else {
      if (in_array($data['type'], [
       'decimal',
       'double'
      ])) {
        array_push($params, (int) $data['precision'], (int) $data['scale']);
      } else {
        if (in_array($data['type'], [
         'char',
         'string'
        ])) {
          array_push($params, (int) $data['length']);
        } else {
          if (in_array($data['type'], ['enum'])) {
            array_push($params, $data['options']);
          }
        }
      }
    }

    return count($params) ? ', ' . join(', ', $params) : '';
  }

  protected function getDefault(array $data) {
    $default = (string) array_get($data, 'default', '');

    return ($default || $default == "0") ? "'{$default}'" : 'null';
  }

  protected function getNullable(array $data) {
    $nullable = (boolean) array_get($data, 'nullable', FALSE);

    return $nullable ? 'true' : 'false';
  }

  protected function getPosition(array $data) {
    $position = array_get($data, 'position', '') ?: NULL;
    if (!empty($position)) {
      return $position === 'first' ? '->first()' : "->after('{$position}')";
    }

    return '';
  }

}
