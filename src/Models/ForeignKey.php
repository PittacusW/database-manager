<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Database\Eloquent\Builder;

class ForeignKey extends Eloquent {

  public $incrementing = FALSE;

  protected $table = 'information_schema.key_column_usage';

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  protected static function boot() {
    parent::boot();
    static::addGlobalScope('default', function(Builder $builder) {
      $builder->selectRaw('table_name, referenced_table_name, table_schema AS origin_connection, table_name AS origin_table, column_name AS origin_column, referenced_table_schema AS referenced_connection, referenced_table_name AS referenced_table, referenced_column_name AS referenced_column');
      $builder->whereIn('constraint_schema', [
       env('DB_DATABASE2'),
       env('DB_DATABASE3')
      ]);
      $builder->whereNotIn('table_name', config('data.ignored_tables'));
      $builder->whereNotIn('referenced_table_name', config('data.ignored_tables'));
      $builder->whereNotNull('referenced_column_name');
    });
  }

  public function getMethod($model) {
    $referenced = $model->tabla === $this->referenced_table;
    $type       = $referenced ? 'origin' : 'referenced';
    $column     = $this->origin_column;
    $class      = studly_case(singularize($this->{"{$type}_table"}));
    $relation   = $referenced ? 'hasMany' : 'belongsTo';
    $namespace  = str_contains($this->{"{$type}_connection"}, 'general') ? 'General' : 'Particular';
    $method     = $this->getMethodName($referenced, $column, $class, $model);

    return with(new Method)->newInstance([
                                          'acceso_id'  => 1,
                                          'estatico'   => FALSE,
                                          'tipo_id'    => 3,
                                          'modelo_id'  => $model->getKey(),
                                          'nombre'     => $method,
                                          'parametros' => [],
                                          'contenido'  => "return \$this->{$relation}(\\PittacusW\DatabaseManager\\Models\\{$namespace}\\{$class}::class, '{$column}');"
                                         ]);
  }

  protected function getMethodName($referenced, $column, $class, $model) {
    return $referenced ? lcfirst(preg_replace("/^{$model->nombre}/", '', $class)) : lcfirst(singularize(str_replace('id', '', $column)));
  }
}
