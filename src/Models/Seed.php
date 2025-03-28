<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Seed {

  public static function find($id) {
    return self::all()
               ->where('id', $id)
               ->first();
  }

  public static function all() {
    return collect(Storage::disk('seeds')
                          ->allFiles())
     ->transform(function($seed) {
       $name = basename($seed, '.php');

       return collect([
                       'id'   => $name,
                       'name' => $name
                      ]);
     })
     ->reject(function($seed) {
       return $seed['id'] === 'DatabaseSeeder';
     })
     ->values();
  }

  public static function generate($action, $table = NULL) {
    if (in_array($action, [
     'iseed',
     'seed'
    ])) {
      $params = self::getParams($action, $table);
      Artisan::call("db:{$action}", $params);
    }

    return self::all();
  }

  private static function getParams($action, $table) {
    return $params = $action === 'seed' ? ['--force' => TRUE] : compact('table');
  }
}
