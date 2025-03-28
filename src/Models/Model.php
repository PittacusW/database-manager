<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Model extends Eloquent {

  protected $table    = 'models';
  protected $fillable = [
   'table'
  ];
  protected $appends  = [
   'name',
   'file',
   'exists',
   'attribute_list',
   'method_list'
  ];
  protected $hidden   = [
   'file',
   'attributes',
   'columns',
   'methods',
   'belognsToRelationships',
   'hasManyRelationships'
  ];
  protected $with     = [
   'attributes',
   'columns',
   'methods',
   'belognsToRelationships',
   'hasManyRelationships'
  ];

  /*------------------------------------------------------------------------------
  | Overrides
  '------------------------------------------------------------------------------*/
  public static function all($columns = ['*']) {
    $dbModels  = self::get($columns)
                     ->keyBy('table');
    $tblModels = Table::currentConnection()
                      ->ignoreTables()
                      ->get()
                      ->transform(function($table) {
                        return with(new self)->newInstance(['table' => $table->name]);
                      })
                      ->keyBy('table');

    return $dbModels->union($tblModels)
                    ->sortBy('table')
                    ->values();
  }

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  public function generateFile() {
    $view = view('layouts.model', ['model' => $this])->render();
    Storage::disk('models')
           ->put($this->archivo, $view);
    Artisan::call('format', ['path' => app_path("Models/{$this->archivo}")]);
  }

  public function getFile() {
    return Storage::disk('models')
                  ->get($this->archivo);
  }

  public function deleteFile() {
    return Storage::disk('models')
                  ->delete($this->archivo);
  }

  public function syncAtributos(array $attributes = []) {
    foreach ($attributes as $tipo_id => $contenido) {
      if (!empty($contenido)) {
        $this->atributos()
             ->setEagerLoads([])
             ->updateOrCreate(compact('tipo_id'), compact('contenido'));
      } else {
        $this->atributos()
             ->setEagerLoads([])
             ->where('tipo_id', $tipo_id)
             ->delete();
      }
    }
  }

  public function atributos() {
    return $this->hasMany(Atributo::class);
  }

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function syncMetodos(array $methods = []) {
    $this->metodos()
         ->setEagerLoads([])
         ->whereNotIn('id', array_pluck($methods, 'id'))
         ->delete();
    foreach ($methods as $method) {
      $this->metodos()
           ->setEagerLoads([])
           ->findOrNew(array_get($method, 'id'))
           ->fill(array_except($method, 'id'))
           ->save();
    }
  }

  public function metodos() {
    return $this->hasMany(Method::class);
  }

  public function columnas() {
    return $this->hasMany(Columna::class, 'table_name', 'tabla');
  }

  public function relacionesBelognsTo() {
    return $this->hasMany(ClaveForanea::class, 'table_name', 'tabla');
  }

  public function relacionesHasMany() {
    return $this->hasMany(ClaveForanea::class, 'referenced_table_name', 'tabla');
  }

  /*------------------------------------------------------------------------------
  | Accessors & Mutators
  '------------------------------------------------------------------------------*/
  public function getNombreAttribute() {
    return studly_case(singularize($this->tabla));
  }

  public function getArchivoAttribute() {
    return "{$this->conexion->namespace}/{$this->nombre}.php";
  }

  public function getExisteAttribute() {
    return $this->exists && Storage::disk('models')
                                   ->exists($this->archivo);
  }

  public function getListaAtributosAttribute() {
    return $this->relationLoaded('atributos') ? $this->atributos->pluck('contenido', 'tipo_id') : collect();
  }

  public function getListaMetodosAttribute() {
    return $this->relationLoaded('metodos') ? $this->metodos : collect();
  }
}