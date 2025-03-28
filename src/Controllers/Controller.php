<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected function formatValidationErrors(Validator $validator) {
    return [
     'data'   => NULL,
     'errors' => $validator->errors()
                           ->toArray(),
     'msg'    => '',
     'total'  => 0
    ];
  }
}
