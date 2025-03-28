<?php

namespace PittacusW\DatabaseManager\Requests;

class UserRequest extends Request {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $rules = [
     'POST' => [
      'nivel'    => 'required|in:1,2',
      'nombre'   => 'required|string|min:3|max:50',
      'correo'   => 'required|email|max:255|unique:usuarios,correo',
      'password' => 'required|string|min:6|confirmed',
      'activo'   => 'sometimes|boolean',
      'file'     => 'sometimes|mimes:jpeg|max:2048'
     ],
     'PUT'  => [
      'nivel'    => 'sometimes|required|in:1,2',
      'nombre'   => 'sometimes|required|string|min:3|max:50',
      'correo'   => "sometimes|required|email|max:255|unique:usuarios,correo,$this->id",
      'password' => 'sometimes|string|min:6|confirmed',
      'activo'   => 'sometimes|boolean',
      'file'     => 'sometimes|mimes:jpeg|max:2048'
     ]
    ];

    return key_exists($this->method(), $rules) ? $rules[$this->method()] : [];
  }
}
