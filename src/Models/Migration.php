<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Migration extends Model {

  protected $table    = 'migrations';
  protected $fillable = [
   'migration',
   'batch'
  ];

  /*------------------------------------------------------------------------------
  | Overrides
  '------------------------------------------------------------------------------*/
  public static function all($columns = ['*']) {
    $dbMigrations = rescue(function() {
      return with(new Migration())
       ->setConnection(current_connection()->nombre)
       ->get();
    }, collect())->keyBy('migration');
    $fsMigrations = collect(Storage::disk('migrations')
                                   ->allFiles())
     ->transform(function($migration) {
       return with(new self)->newInstance([
                                           'migration' => basename($migration, '.php'),
                                           'batch'     => '-'
                                          ]);
     })
     ->keyBy('migration');

    return $dbMigrations->union($fsMigrations)
                        ->sortByDesc('migration')
                        ->values();
  }

  public static function generate($action, $connection) {
    if (in_array($action, [
     'do',
     'undo',
     'drop'
    ])) {
      Artisan::call("migrate:{$action}", compact('connection'));
    }
  }
}
