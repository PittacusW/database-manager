<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use PittacusW\DatabaseManager\Models\Controlador;

class ControllerController extends Controller {

  public function show($id, Request $request) {
    $controlador = Controlador::findOrFail($id);
    if ($request->input('file', FALSE)) {
      $controlador = $controlador->getFile();
    }

    return response()->json(compact('controlador'));
  }

  public function store(Request $request) {
    $conexion_id = $request->input('connection');
    Controlador::all()
               ->each(function($controlador) use ($conexion_id) {
                 if (!$controlador->exists) {
                   $controlador->fill(compact('conexion_id'))
                               ->save();
                 }
                 $controlador->generateFile();
               });

    return $this->index();
  }

  public function index() {
    $controladores = Controlador::all();

    return response()->json(compact('controladores'));
  }

  public function update($id, Request $request) {
    $controlador = Controlador::findOrFail($id);
    $controlador->syncAtributos($request->input('lista_atributos', []));
    $controlador->syncMetodos($request->input('lista_metodos', []));
    $controlador->generateFile();

    return response()->json(compact('controlador'));
  }

  public function destroy($id) {
    $controlador = Controlador::findOrFail($id);
    $controlador->delete($id);
    $controlador->deleteFile();

    return response()->json(compact('controlador'));
  }
}
