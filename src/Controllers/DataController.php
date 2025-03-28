<?php

namespace PittacusW\DatabaseManager\Controllers;

use PittacusW\DatabaseManager\Models\Data;
use PittacusW\DatabaseManager\Models\Semilla;
use PittacusW\DatabaseManager\Requests\DataRequest;

class DataController extends Controller {

  public function index(DataRequest $request) {
    $data = with(new Data)
     ->prepare($request->input('table'), FALSE)
     ->paginate($request->get('limit', 50));

    return response()->json(compact('data'));
  }

  public function store(DataRequest $request) {
    $table  = $request->input('table');
    $action = $request->input('_action');
    $model  = with(new Data)->prepare($table);
    switch ($action) {
      case 'create':
        $data = $model->fill($request->all());
        $data->save();
        break;
      case 'update':
        $data = $model->findOrFail($request->input($model->getKeyName()));
        $data->prepare($table)
             ->update($request->all());
        break;
      case 'delete':
        $data = $model->findOrFail($request->input($model->getKeyName()));
        $data->prepare($table)
             ->delete();
        break;
    }
    Semilla::generate('iseed', $table);

    return response()->json(compact('data'));
  }
}
