<?php

namespace PittacusW\DatabaseManager\Controllers;

use Arcanedev\LogViewer\Facades\LogViewer;
use Arcanedev\LogViewer\Entities\LogEntryCollection;

class LogController extends Controller {

  public function index() {
    $logs = array_values(LogViewer::statsTable()
                                  ->rows());

    return response()->json(compact('logs'));
  }

  public function show($date) {
    $log = $this->get($date);

    return response()->json(compact('log'));
  }

  private function get($date) {
    return rescue(function() use ($date) {
      return LogViewer::get($date)
                      ->entries();
    }, new LogEntryCollection);
  }

  public function destroy($date) {
    $log = $this->get($date);
    if (!$log->isEmpty()) {
      LogViewer::delete($date);
    }

    return response()->json(compact('log'));
  }
}
