<?php

namespace PittacusW\DatabaseManager\Models;

class MethodType extends Eloquent {

  protected $table    = 'metodos_tipos';
  protected $fillable = ['nombre'];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function funciones() {
    return $this->hasMany(Method::class);
  }
}
