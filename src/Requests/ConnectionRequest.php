<?php

namespace PittacusW\DatabaseManager\Requests;

class ConnectionRequest extends Request {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $rules = [
     'connection' => [
      'required',
      'int',
      'exists:dev.conexiones,id,id,!1'
     ]
    ];

    return $rules;
  }
}
