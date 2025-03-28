<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use PittacusW\DatabaseManager\Models\Objeto;

class PasswordController extends Controller {

  public $username = 'email';
  public $password = 'password';
  public $guard    = 'web';

  public function __construct() {
    $this->middleware("guest:{$this->guard}");
    if ($this->guard === 'contal') {
      config()->set('auth.defaults.passwords', 'persons');
    }
  }

  public function reset(Request $request) {
    $this->validateRequest($request);
    $response = $this->broker()
                     ->reset($this->credentials($request), function($user, $password) {
                       $this->resetPassword($user, $password);
                     });

    return $response == Password::PASSWORD_RESET ? $this->sendSucceedResetResponse() : $this->sendResetFailedResponse($response);
  }

  protected function validateRequest(Request $request) {
    $this->validate($request, [
     'token'           => 'required',
     $this->username() => 'required',
     $this->password() => 'required',
    ]);
  }

  protected function username() {
    return $this->username;
  }

  protected function password() {
    return $this->password;
  }

  protected function broker() {
    return Password::broker();
  }

  protected function credentials(Request $request) {
    return $request->only($this->username(), $this->password(), "{$this->password()}_confirmation", 'token');
  }

  protected function resetPassword($user, $password) {
    $password = $this->guard === 'web' ? bcrypt($password) : Objeto::newInstance('Auth', [
     'dbp',
     'dbg'
    ])
                                                                   ->fill(compact('password'))
                                                                   ->exec('generatorPassword');
    $user->forceFill([$this->password() => $password])
         ->save();
  }

  protected function sendSucceedResetResponse() {
    return response()->json([]);
  }

  protected function sendResetFailedResponse($response) {
    $message = trans($response);
    $errors  = [($response === Password::INVALID_PASSWORD ? $this->password() : $this->username()) => [$message]];

    return response()->json(compact('errors'), 422);
  }

  protected function guard() {
    return auth($this->guard);
  }
}