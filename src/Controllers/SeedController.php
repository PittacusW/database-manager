<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PittacusW\DatabaseManager\Models\Semilla;

class SeedController extends Controller {

  public function index() {
    $seeds = Semilla::all();

    return response()->json(compact('seeds'));
  }

  public function show($id) {
    $seed = Semilla::find($id);
    $data = Storage::disk('seeds')
                   ->get("{$seed->get('name')}.php");

    return response()->json(compact('data'));
  }

  public function store(Request $request) {
    $action = $request->input('action', 'iseed');
    $seeds  = Semilla::generate($action);

    return response()->json(compact('seeds'));
  }
}
