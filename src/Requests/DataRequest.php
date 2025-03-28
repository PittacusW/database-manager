<?php

namespace PittacusW\DatabaseManager\Requests;

use PittacusW\DatabaseManager\Models\Table;
use PittacusW\DatabaseManager\Models\Column;

class DataRequest extends Request {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $tables = Table::currentConnection()
                   ->get()
                   ->implode('name', ',');
    $rules  = [
     'table' => [
      'required',
      'string',
      "in:{$tables}"
     ]
    ];
    if ($this->method() === 'POST') {
      $columns = Column::currentConnection()
                       ->whereTable($this->table)
                       ->get();
      $columns->each(function($column) use (&$rules) {
        $rules[$column->name] = [($column->nullable ? 'required' : 'nullable')];
      });
    }

    return $rules;
  }
}