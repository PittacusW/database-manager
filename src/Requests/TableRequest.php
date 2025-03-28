<?php

namespace PittacusW\DatabaseManager\Requests;

use PittacusW\DatabaseManager\Models\Admin\Tabla;

class TableRequest extends Request {

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
     'name' => [
      'required',
      'string',
      'min:1',
      'max:64',
      "not_in:{$tables}"
     ]
    ];

    return $rules;
  }
}
