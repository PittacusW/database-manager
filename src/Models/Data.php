<?php

namespace PittacusW\DatabaseManager\Models;

class Data extends Eloquent {

  protected $table      = '';
  protected $primaryKey = '';
  protected $fillable   = [];

  public function prepare($table, $all = TRUE) {
    $this->setTable($table);
    if ($all) {
      $columns = Column::all($table);
      $this->fillable($columns->where('primary', 0)
                              ->pluck('name')
                              ->all());
      $this->setKeyName($columns->where('primary', 1)
                                ->pluck('name')
                                ->first());
    }

    return $this;
  }
}
