<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use PittacusW\DatabaseManager\Models\General\Usuario;
use PittacusW\DatabaseManager\Requests\Admin\UsuarioRequest;
use PittacusW\DatabaseManager\Requests\Admin\UsuarioProfileRequest;

class UserController extends Controller {

  public function index(Request $request) {
    $this->authorize('index', Usuario::class);
    $data = Usuario::orderBy('nivel')
                   ->orderBy('correo')
                   ->orderBy('nombre')
                   ->paginate($request->input('limit', 50));

    return response()->json(compact('data'));
  }

  public function store(UsuarioRequest $request) {
    $this->authorize('store', Usuario::class);
    $user = Usuario::create($request->all());
    $user->upload($request->file('file'));

    return response()->json(compact('user'));
  }

  public function update(Usuario $user, UsuarioRequest $request) {
    $this->authorize('update', Usuario::class);
    $user->update($request->all());
    $user->upload($request->file('file'));

    return response()->json(compact('user'));
  }

  public function destroy(Usuario $user) {
    $this->authorize('destroy', Usuario::class);
    $user->eliminate();

    return response()->json(compact('user'));
  }

  public function profile(UsuarioProfileRequest $request) {
    $user = $request->user();
    $user->update($request->only('nombre', 'password'));
    $user->upload(array_get($request->file('file'), 0));
    $user->certificate(array_get($request->file('file'), 1), $request->input('certificate_password'));

    return response()->json(compact('user'));
  }
}
