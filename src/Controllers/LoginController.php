<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller {

  use ThrottlesLogins;

  public $username = 'correo';
  public $password = 'password';
  public $guard    = 'web';
  public $redirect = '/';

  public function __construct() {
    $this->middleware("guest:{$this->guard}", ['except' => 'logout']);
  }

  public function login(Request $request) {
    $this->validateRequest($request);
    if ($this->hasTooManyLoginAttempts($request)) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }
    if ($this->guard()
             ->attempt($this->credentials($request), $request->input('remember', FALSE))) {
      $this->fireSucceedLoginActions($request);

      return $this->sendSucceedLoginResponse($request);
    }
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse();
  }

  protected function validateRequest(Request $request) {
    $this->validate($request, [
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

  protected function sendLockoutResponse(Request $request) {
    $seconds = $this->limiter()
                    ->availableIn($this->throttleKey($request));
    $message = trans('auth.throttle', ['seconds' => $seconds]);
    $errors  = [$this->username() => [$message]];

    return response()->json(compact('errors'), 422);
  }

  protected function guard() {
    return auth($this->guard);
  }

  protected function credentials(Request $request) {
    return $request->only($this->username(), $this->password());
  }

  protected function fireSucceedLoginActions(Request $request) {
    //
  }

  protected function sendSucceedLoginResponse(Request $request) {
    $this->clearLoginAttempts($request);
    $request->session()
            ->regenerate();
    $model = $this->guard()
                  ->user();

    return response()->json(compact('model'));
  }

  protected function sendFailedLoginResponse() {
    $message = trans('auth.failed');
    $errors  = [$this->password() => [$message]];

    return response()->json(compact('errors'), 422);
  }

  public function logout(Request $request) {
    $this->guard()
         ->logout();
    $request->session()
            ->flush();
    $request->session()
            ->regenerate();

    return redirect(app()->environment('production') ? '/' : $this->redirect);
  }
}