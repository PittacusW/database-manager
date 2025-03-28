<?php

namespace PittacusW\DatabaseManager\Controllers;

use PittacusW\DatabaseManager\Models\Column;
use PittacusW\DatabaseManager\Events\ColumnDeleted;
use PittacusW\DatabaseManager\Events\ColumnUpdated;
use PittacusW\DatabaseManager\Events\ColumnCreated;
use PittacusW\DatabaseManager\Requests\ColumnRequest;

class ColumnController extends Controller {

  public function index(ColumnRequest $request) {
    $columns = Column::currentConnection()
                     ->whereTable($request->input('table'))
                     ->get();

    return response()->json(compact('columns'));
  }

  public function store(ColumnRequest $request) {
    event(new ColumnCreated($request->all()));
    $column = Column::currentConnection()
                    ->whereTable($request->input('table'))
                    ->findOrFail($request->input('name'));

    return response()->json(compact('column'));
  }

  public function update($id, ColumnRequest $request) {
    $newData = $request->all();
    $oldData = Column::currentConnection()
                     ->whereTable($request->input('table'))
                     ->findOrFail($id)
                     ->toArray();
    event(new ColumnUpdated($oldData, $newData));
    $column = Column::currentConnection()
                    ->whereTable($request->input('table'))
                    ->findOrFail($id);

    return response()->json(compact('column'));
  }

  public function destroy($id, ColumnRequest $request) {
    $column = Column::currentConnection()
                    ->whereTable($request->input('table'))
                    ->findOrFail($id);
    event(new ColumnDeleted($column->toArray()));

    return response()->json(compact('column'));
  }
}
