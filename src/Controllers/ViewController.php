<?php

namespace PittacusW\DatabaseManager\Controllers;

use Illuminate\Support\Str;

class ViewController extends Controller {

  protected $path = 'database-manager::modules';

  public function app() {
    return view(Str::finish($this->path, '.app'));
  }

  public function views($view) {
    $view = Str::finish($this->path, ".$view");
    if (!view()->exists($view)) {
      return abort(404);
    }

    return view($view);
  }
}
