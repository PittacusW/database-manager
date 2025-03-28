{!! '<?' !!}php

namespace App\Controllers\{!! $namespace !!};

use App\Controllers\Controller;use App\Models\{!! $namespace !!}\{!! $model !!};use Illuminate\Http\Request;

class {!! $model !!}Controller extends Controller {

public function index() {$data = {!! $model !!}::all();return response()->json(compact('data'));}

public function show($id) {$data = {!! $model !!}::findOrFail($id);return response()->json(compact('data'));}

public function store(Request $request) {$data = {!! $model !!}::create($request->all());return response()->json(compact('data'));}

public function update($id, Request $request) {$data = {!! $model !!}::findOrFail($id);$data->update($request->all());return response()->json(compact('data'));}

public function destroy($id) {$data = {!! $model !!}::findOrFail($id);$data->delete();return response()->json(compact('data'));}

}
