<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Database\Eloquent\Builder;

class Table extends Eloquent {

  public    $incrementing = FALSE;
  protected $table        = 'information_schema.tables';
  protected $primaryKey   = 'table_name';

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  protected static function boot() {
    parent::boot();
    static::addGlobalScope('default', function(Builder $builder) {
      $builder->selectRaw("table_name AS id, table_name as name");
      $builder->where('table_schema', env('DB_DATABASE'));
      $builder->orderBy('table_name');
    });
  }

  /*------------------------------------------------------------------------------
  | Scopes
  '------------------------------------------------------------------------------*/
  public function scopeCurrentConnection($query) {
    return $query->whereNotIn('table_name', config('database-manager.ignored_tables'));
  }

  public function scopeWhereConnection($query, $connection) {
    return $query->having('connection', $connection);
  }

  public function scopeIgnoreTables($query) {
    return $query->whereNotIn('table_name', config('database-manager.ignored_tables'));
  }
}
