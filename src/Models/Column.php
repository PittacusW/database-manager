<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Database\Eloquent\Builder;

class Column extends Eloquent {

  public    $incrementing = FALSE;
  protected $table        = 'information_schema.columns';
  protected $primaryKey   = 'column_name';

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  protected static function boot() {
    parent::boot();
    static::addGlobalScope('default', function(Builder $builder) {
      $builder->selectRaw("table_name, column_name, column_name AS 'id', column_name AS 'name', table_name AS 'table', (CASE WHEN column_type = 'blob' THEN 'binary' WHEN column_type = 'tinyint(1)' THEN 'boolean' WHEN data_type = 'int' THEN 'integer' WHEN data_type LIKE '%int' THEN REPLACE(data_type, 'int', 'Integer') WHEN data_type = 'text' THEN 'text' WHEN data_type LIKE '%text' THEN REPLACE(data_type, 'text', 'Text') WHEN data_type = 'varchar' THEN 'string' ELSE data_type END) AS 'type', column_default AS 'default', IF(column_key = 'PRI', true, false) AS 'primary', IF(column_key IN('PRI', 'UNI'), true, false) AS 'unique', IF(column_key = 'MUL', true, false) AS 'index', IF(is_nullable = 'YES', true, false) AS 'nullable', IF(INSTR(column_type, 'unsigned'), true, false) AS 'unsigned', IF(extra = 'auto_increment', true, false) AS 'autoincrement', IF(data_type IN('char', 'varchar'), character_maximum_length, null) AS 'length', IF(data_type IN('decimal', 'double'), numeric_precision, null) AS 'precision', IF(data_type IN('decimal', 'double'), IFNULL(numeric_scale, 0), null) AS 'scale', REPLACE(IF(data_type = 'enum', SUBSTRING_INDEX(substr(column_type, INSTR(column_type, '(') + 1), ')', 1), null), \"'\", '') AS 'options'");
      $builder->whereIn('table_schema', env('DB_DATABASE'));
    });
  }

  /*------------------------------------------------------------------------------
  | Scopes
  '------------------------------------------------------------------------------*/

  public function scopeWhereTable($query, $table) {
    return $query->where('table_name', $table);
  }

  /*------------------------------------------------------------------------------
  | Accessors && Mutators
  '------------------------------------------------------------------------------*/
  public function getDefaultAttribute($value) {
    return empty($value) || strtolower($value) === 'null' ? NULL : $value;
  }
}
