<?php

namespace PittacusW\DatabaseManager\Models;

class Method extends Eloquent {

  protected $table    = 'methods';
  protected $fillable = [
   'acceso_id',
   'estatico',
   'tipo_id',
   'modelo_id',
   'nombre',
   'parametros',
   'contenido'
  ];
  protected $hidden   = [
   'acceso',
   'tipo'
  ];
  protected $with     = [
   'acceso',
   'tipo'
  ];
  protected $casts    = [
   'estatico'   => 'boolean',
   'parametros' => 'array'
  ];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function tipo() {
    return $this->belongsTo(MethodType::class, 'tipo_id');
  }

  public function acceso() {
    return $this->belongsTo(MethodAccess::class, 'acceso_id');
  }

  public function modelo() {
    return $this->belongsTo(Model::class, 'modelo_id');
  }

  /*------------------------------------------------------------------------------
  | Accessors & Mutators
  '------------------------------------------------------------------------------*/
  public function setNombreAttribute($value) {
    $this->attributes['nombre'] = lcfirst($value);
  }

  public function getParametrosAttribute($value) {
    return empty($value) ? [] : json_decode($value, TRUE);
  }
}
