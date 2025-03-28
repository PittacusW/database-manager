<?php

namespace PittacusW\DatabaseManager\Models;

class AttributeType extends Eloquent {

  protected $table    = 'atributos_tipos';
  protected $fillable = ['nombre'];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function attributes() {
    return $this->hasMany(Atributo::class);
  }
}
