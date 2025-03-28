<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Connection extends Eloquent {

  protected $table    = 'connections';
  protected $fillable = [
   'name',
   'namespace'
  ];
  protected $appends  = ['database'];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public static function truncateTables($connection) {
    Schema::connection($connection)
          ->disableForeignKeyConstraints();
    foreach (Table::whereConnection($connection)
                  ->ignoreTables(['migrations'])
                  ->pluck('name') as $table) {
      DB::connection($connection)
        ->table($table)
        ->truncate();
    }
    Schema::connection($connection)
          ->enableForeignKeyConstraints();
  }

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  public static function dropTables($connection) {
    Schema::connection($connection)
          ->disableForeignKeyConstraints();
    foreach (Table::whereConnection($connection)
                  ->pluck('name') as $table) {
      Schema::connection($connection)
            ->drop($table);
    }
    Schema::connection($connection)
          ->enableForeignKeyConstraints();
  }

  public static function setDefaultConnection($connection) {
    $config = 'database.default';
    if (config($config) !== $connection) {
      DB::purge($connection);
    }
    config()->set($config, $connection);
  }

  public static function setConnectionDatabaseName($connection, $name) {
    $config = "database.connections.{$connection}.database";
    if (config($config) !== $name) {
      DB::purge($connection);
    }
    config()->set($config, $name);
  }

  public function models() {
    return $this->hasMany(Model::class);
  }

  /*------------------------------------------------------------------------------
  | Accessors && Mutators
  '------------------------------------------------------------------------------*/
  public function getDatabaseAttribute() {
    return config("database.connections.{$this->nombre}.database");
  }
}
