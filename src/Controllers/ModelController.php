<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use PittacusW\DatabaseManager\Models\Model;

class ModelController extends Controller {

  public function index() {
    $modelos = Model::all();

    return response()->json(compact('modelos'));
  }

  public function show($id, Request $request) {
    $modelo = Model::findOrFail($id);
    if ($request->input('file', FALSE)) {
      $modelo = $modelo->getFile();
    }

    return response()->json(compact('modelo'));
  }

  public function store(Request $request) {
    $conexion_id = $request->input('connection');
    $modelos     = Model::all()
                        ->transform(function($modelo) use ($conexion_id) {
                          if (!$modelo->exists) {
                            $modelo->fill(compact('conexion_id'))
                                   ->save();
                            $modelo->refresh();
                          }
                          $modelo->generateFile();

                          return $modelo;
                        });

    return response()->json(compact('modelos'));
  }

  public function update($id, Request $request) {
    $modelo = Model::findOrFail($id);
    $modelo->syncAtributos($request->input('lista_atributos', []));
    $modelo->syncMetodos($request->input('lista_metodos', []));
    $modelo->refresh();
    $modelo->generateFile();

    return response()->json(compact('modelo'));
  }

  public function destroy($id) {
    $modelo = Model::findOrFail($id);
    $modelo->delete($id);
    $modelo->deleteFile();

    return response()->json(compact('modelo'));
  }
}
