<?php

namespace PittacusW\DatabaseManager\Traits;

use PittacusW\DatabaseManager\Models\Admin\Modelo;

trait Modelable {

  function makeObject($table) {
    $model = Modelo::firstOrNew([
                                 'tabla'       => $table,
                                 'conexion_id' => current_connection()->id
                                ]);
    if (!$model->exists) {
      $model->save();
    }
    $model->generateFile();
  }

  function updateObject($oldTable, $newTable = NULL) {
    $model = Modelo::firstOrNew([
                                 'tabla'       => $oldTable,
                                 'conexion_id' => current_connection()->id
                                ]);
    if ($model->exists) {
      $model->deleteFile();
      $model->when($newTable, function($model) use ($newTable) {
        $model->fill(['tabla' => $newTable])
              ->save();
      });
      $model->generateFile();
    }
  }

  function deleteObject($table) {
    $model = Modelo::firstOrNew([
                                 'tabla'       => $table,
                                 'conexion_id' => current_connection()->id
                                ]);
    if ($model->exists) {
      $model->delete();
      $model->deleteFile();
    }
  }
}
