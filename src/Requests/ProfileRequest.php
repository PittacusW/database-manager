<?php

namespace PittacusW\DatabaseManager\Requests;

class ProfileRequest extends Request {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $type = collect(config('data.files_types'))
     ->where('id', 'certificate')
     ->first();

    return [
     'nombre'               => 'required|string|min:3|max:50',
     'password_current'     => 'sometimes|current_password',
     'password'             => 'sometimes|min:6|confirmed',
     'file'                 => 'sometimes|array',
     'file.0'               => 'sometimes|nullable|mimes:png|max:2048',
     'file.1'               => "sometimes|nullable|mimes:{$type['accept']}|max:{$type['size']}",
     'certificate_password' => 'sometimes|string'
    ];
  }
}
