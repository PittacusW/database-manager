<?php

namespace PittacusW\DatabaseManager\Requests;

use PittacusW\DatabaseManager\Models\Admin\Tabla;
use PittacusW\DatabaseManager\Models\Admin\Columna;

class ColumnRequest extends Request {

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
      $columns                = Columna::currentConnection()
                                       ->whereTable($this->table)
                                       ->where('column_name', '<>', $this->name)
                                       ->get()
                                       ->implode('id', ',');
      $types                  = collect(config('data.columns_types', []))->implode('id', ',');
      $rules['type']          = [
       'required',
       'string',
       "in:{$types}"
      ];
      $rules['name']          = [
       'required',
       'string',
       'min:1',
       'max:64',
       "not_in:{$columns}"
      ];
      $rules['precision']     = [
       'nullable',
       'required_if:type,decimal,double,float',
       'integer',
       'min:1',
       'max:65'
      ];
      $rules['scale']         = [
       'nullable',
       'required_if:type,decimal,double,float',
       'integer',
       'min:0',
       'max:30'
      ];
      $rules['length']        = [
       'nullable',
       'required_if:type,char,string',
       'integer',
       'min:1',
       'max:255'
      ];
      $rules['options']       = [
       'nullable',
       'required_if:type,enum',
       'array'
      ];
      $rules['default']       = [
       'sometimes',
       'nullable',
       'string'
      ];
      $rules['nullable']      = [
       'sometimes',
       'boolean'
      ];
      $rules['unsigned']      = [
       'sometimes',
       'boolean'
      ];
      $rules['autoincrement'] = [
       'sometimes',
       'boolean'
      ];
      $rules['position']      = [
       'nullable',
       'string',
       "in:first,{$columns}"
      ];
    }

    return $rules;
  }
}
