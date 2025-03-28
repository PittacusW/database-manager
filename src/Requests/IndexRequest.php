<?php

namespace PittacusW\DatabaseManager\Requests;

use PittacusW\DatabaseManager\Models\Admin\Tabla;
use PittacusW\DatabaseManager\Models\Admin\Indice;
use PittacusW\DatabaseManager\Models\Admin\Columna;
use PittacusW\DatabaseManager\Models\Admin\Conexion;

class IndexRequest extends Request {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $tables = Tabla::currentConnection()
                   ->get()
                   ->implode('id', ',');
    $rules  = [
     'table' => [
      'required',
      'string',
      "in:{$tables}"
     ]
    ];
    if (in_array($this->method(), [
     'POST',
     'PUT'
    ])) {
      $types                                  = collect(config('data.indexes_types', []))->implode('id', ',');
      $columns                                = Columna::currentConnection()
                                                       ->whereTable($this->table)
                                                       ->get()
                                                       ->implode('id', ',');
      $names                                  = Indice::all($this->table)
                                                      ->pluck('name')
                                                      ->filter(function($name) {
                                                        return $this->method() === 'POST' || $name !== $this->name;
                                                      })
                                                      ->implode(',');
      $rules['type']                          = [
       'required',
       'string',
       "in:{$types}"
      ];
      $rules['column']                        = [
       'required',
       'string',
       "in:{$columns}"
      ];
      $rules['name']                          = [
       'required',
       'string',
       'min:1',
       'max:64',
       "not_in:{$names}"
      ];
      $connections                            = Conexion::all()
                                                        ->implode('nombre', ',');
      $fkTables                               = Tabla::whereConnection(array_get($this->foreign_data, 'connection'))
                                                     ->get()
                                                     ->implode('id', ',');
      $fkColumns                              = Columna::whereConnection(array_get($this->foreign_data, 'connection'))
                                                       ->whereTable(array_get($this->foreign_data, 'table'))
                                                       ->get()
                                                       ->implode('id', ',');
      $fkNames                                = Indice::all($this->table)
                                                      ->pluck('foreign_data.name')
                                                      ->filter(function($name) {
                                                        return !empty($name) && ($this->method() === 'POST' || $name !== array_get($this->foreign_data, 'name'));
                                                      })
                                                      ->implode(',');
      $fkOptions                              = collect(config('data.fk_options', []))->implode('id', ',');
      $rules['foreign']                       = 'nullable|boolean';
      $rules['foreign_data.connection']       = "required_if:foreign,true|string|in:{$connections}";
      $rules['foreign_data.table']            = "required_if:foreign,true|string|in:{$fkTables}";
      $rules['foreign_data.column']           = "required_if:foreign,true|string|in:{$fkColumns}";
      $rules['foreign_data.name']             = "required_if:foreign,true|string|min:1|max:64|not_in:{$fkNames}";
      $rules['foreign_data.options.onUpdate'] = "required_if:foreign,true|string|in:{$fkOptions}";
      $rules['foreign_data.options.onDelete'] = "required_if:foreign,true|string|in:{$fkOptions}";
    }

    return $rules;
  }
}
