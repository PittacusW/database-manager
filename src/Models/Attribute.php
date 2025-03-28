<?php

namespace PittacusW\DatabaseManager\Models;

class Attribute extends Eloquent {

  protected $table    = 'atributos';
  protected $fillable = [
   'tipo_id',
   'modelo_id',
   'contenido'
  ];
  protected $casts    = ['contenido' => 'array'];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function tipo() {
    return $this->belongsTo(AtributoTipo::class, 'tipo_id');
  }

  public function modelo() {
    return $this->belongsTo(Model::class, 'modelo_id');
  }
}
