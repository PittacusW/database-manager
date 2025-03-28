<?php

namespace PittacusW\DatabaseManager\Controllers;

use PittacusW\DatabaseManager\Models\Table;
use PittacusW\DatabaseManager\Events\TableDeleted;
use PittacusW\DatabaseManager\Events\TableUpdated;
use PittacusW\DatabaseManager\Events\TableCreated;
use PittacusW\DatabaseManager\Requests\Admin\TablaRequest;

class TableController extends Controller {

  public function index() {
    $records = Table::currentConnection()
                    ->get();

    return response()->json(compact('records'));
  }

  public function store(TablaRequest $request) {
    event(new TableCreated($request->all()));
    $records = Table::currentConnection()
                    ->findOrFail($request->input('name'));

    return response()->json(compact('records'));
  }

  public function update($id, TablaRequest $request) {
    event(new TableUpdated([
                            'oldName' => $id,
                            'newName' => $request->input('name')
                           ]));
    $table = Table::currentConnection()
                  ->findOrFail($request->input('name'));

    return response()->json(compact('table'));
  }

  public function destroy($id) {
    $table = Table::currentConnection()
                  ->findOrFail($id);
    event(new TableDeleted($id));

    return response()->json(compact('table'));
  }
}
