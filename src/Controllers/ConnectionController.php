<?php

namespace PittacusW\DatabaseManager\Controllers;

use PittacusW\DatabaseManager\Models\Table;
use PittacusW\DatabaseManager\Models\Columna;
use PittacusW\DatabaseManager\Models\Connection;

class ConnectionController extends Controller {

  public function index() {
    $databases = Connection::all();

    return response()->json(compact('databases'));
  }

  public function tables() {
    $tables = Table::all();

    return response()->json(compact('tables'));
  }

  public function columns() {
    $columns = Columna::all();

    return response()->json(compact('columns'));
  }
}
