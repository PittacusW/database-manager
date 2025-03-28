<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Database\Eloquent\Model;

class Eloquent extends Model {

  protected $appends = ['id'];
  protected $hidden  = [
   'created_at',
   'updated_at',
   'deleted_at'
  ];
  protected $dates   = [
   'created_at',
   'updated_at',
   'deleted_at'
  ];

  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  public function syncMany(array $data, $relation, $id) {
    $this->{$relation}()
         ->whereNotIn($id, array_pluck($data, $id))
         ->delete();
    foreach ($data as $item) {
      $this->{$relation}()
           ->updateOrCreate(array_only($item, $id), array_except($item, $id));
    }
  }

  /*------------------------------------------------------------------------------
  | Accessors & Mutators
  '------------------------------------------------------------------------------*/
  public function getIdAttribute() {
    return $this->getKey();
  }
}
