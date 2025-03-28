<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PittacusW\DatabaseManager\Models\Migration;

class MigrationController extends Controller {

  public function show($id) {
    $migration = Storage::disk('migrations')
                        ->get("{$id}.php");

    return response()->json(compact('migration'));
  }

  public function store(Request $request) {
    Migration::generate($request->input('action'), current_connection()->nombre);

    return $this->index();
  }

  public function index() {
    $migrations = Migration::all();

    return response()->json(compact('migrations'));
  }
}
