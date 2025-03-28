<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use PittacusW\DatabaseManager\Models\Indice;
use PittacusW\DatabaseManager\Requests\Admin\IndiceRequest;

class IndexController extends Controller {

  public function index(IndiceRequest $request) {
    $columns = Indice::all($request->input('table'));

    return response()->json(compact('columns'));
  }

  public function store(IndiceRequest $request) {
    $column = Indice::create($request->all());

    return response()->json(compact('column'));
  }

  public function update($id, IndiceRequest $request) {
    $column = Indice::update($id, $request->all());

    return response()->json(compact('column'));
  }

  public function destroy($id, Request $request) {
    $column = Indice::delete($request->input('table'), $id);

    return response()->json(compact('column'));
  }

  public function types() {
    $types = config('data.indexes_types', []);

    return response()->json(compact('types'));
  }
}
