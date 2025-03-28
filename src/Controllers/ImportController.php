<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Http\Request;
use PittacusW\DatabaseManager\Models\Import;
use PittacusW\DatabaseManager\Models\General\Empresa;
use PittacusW\DatabaseManager\Requests\Admin\ImportRequest;

class ImportController extends Controller {

  public $import;

  public function __construct(Request $request) {
    $Empresa      = Empresa::findOrFail($request->input('id'));
    $file         = $request->file('file');
    $pass         = $request->input('file_password');
    $this->import = new Import($Empresa, $file, $pass);
    $method       = $this->typeToMethod('get', $request->input('file_type'));
    $request->merge($this->import->$method($request));
  }

  private function typeToMethod($prefix, $type) {
    return $prefix . studly_case($type);
  }

  public function index(ImportRequest $request) {
    $this->authorize('import', Empresa::class);
    if ($request->has('errors')) {
      return response()->json($request->only('errors'), 422);
    }
    $method = $this->typeToMethod('store', $request->input('file_type'));

    return $this->$method($request);
  }

  private function storeDocument(ImportRequest $request) {
    $data = $this->import->createDocument($request->input('readxml'));

    return $this->response($data);
  }

  private function response(array $data) {
    return array_has($data, 'errors') ? response()->json(array_only($data, 'errors'), 422) : response()->json($data);
  }

  private function storeCertificate(ImportRequest $request) {
    $data = $this->import->createCertificate($request->input('certificado'));

    return $this->response($data);
  }

  private function storeTestFolio(ImportRequest $request) {
    $data = $this->import->createTestFolio($request->input('folio'));

    return $this->response($data);
  }
}
