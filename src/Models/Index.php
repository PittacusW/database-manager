<?php

namespace PittacusW\DatabaseManager\Models;

use Illuminate\Support\Facades\Schema;
use PittacusW\DatabaseManager\Events\IndexDeleted;
use PittacusW\DatabaseManager\Events\IndexUpdated;
use PittacusW\DatabaseManager\Events\IndexCreated;

class Index {

  public static function create($data) {
    event(new IndexCreated($data));

    return self::find($data['table'], $data['name']);
  }

  public static function find($table, $id) {
    return self::all($table)
               ->where('id', $id)
               ->first();
  }

  public static function all($table) {
    $tables      = Table::all();
    $doctrine    = Schema::getConnection()
                         ->getDoctrineSchemaManager();
    $foreignKeys = collect($doctrine->listTableForeignKeys($table))->mapWithKeys(function($foreign) use ($tables) {
      return [
       array_first($foreign->getLocalColumns()) => [
        'id'         => $foreign->getName(),
        'name'       => $foreign->getName(),
        'connection' => $tables->where('id', $foreign->getForeignTableName())
                               ->first()->connection,
        'table'      => $foreign->getForeignTableName(),
        'column'     => array_first($foreign->getForeignColumns()),
        'options'    => $foreign->getOptions()
       ]
      ];
    });
    $indexes     = collect($doctrine->listTableIndexes($table))
     ->transform(function($index) use ($table, $foreignKeys) {
       return [
        'id'           => $index->getName(),
        'type'         => $index->isPrimary() ? 'primary' : ($index->isUnique() ? 'unique' : 'index'),
        'name'         => $index->getName(),
        'table'        => $table,
        'column'       => array_first($index->getColumns()),
        'foreign'      => $foreignKeys->has(array_first($index->getColumns())),
        'foreign_data' => $foreignKeys->get(array_first($index->getColumns()))
       ];
     })
     ->sortBy('name')
     ->values();

    return $indexes;
  }

  public static function update($id, $data) {
    $index = self::find($data['table'], $id);
    event(new IndexUpdated($index, $data));

    return self::find($data['table'], $data['name']);
  }

  public static function delete($table, $id) {
    $index = self::find($table, $id);
    event(new IndexDeleted($index));

    return $index;
  }
}