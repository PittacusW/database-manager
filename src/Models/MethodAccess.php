<?php

namespace PittacusW\DatabaseManager\Models;

class MethodAccess extends Eloquent {

  protected $table    = 'metodos_accesos';
  protected $fillable = ['nombre'];

  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  public function funciones() {
    return $this->hasMany(Method::class);
  }
}
