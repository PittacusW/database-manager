<?php

namespace PittacusW\DatabaseManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return TRUE;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [//
    ];
  }
}
