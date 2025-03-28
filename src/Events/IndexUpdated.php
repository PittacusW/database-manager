<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class IndexUpdated {

  use SerializesModels;

  public $type;
  public $action;
  public $table;
  public $column;
  public $oldName;
  public $oldMethod;
  public $oldDropMethod;
  public $oldForeign;
  public $oldForeignConnection;
  public $oldForeignTable;
  public $oldForeignColumn;
  public $oldForeignName;
  public $oldForeignOnUpdate;
  public $oldForeignOnDelete;
  public $newName;
  public $newMethod;
  public $newDropMethod;
  public $newForeign;
  public $newForeignConnection;
  public $newForeignTable;
  public $newForeignColumn;
  public $newForeignName;
  public $newForeignOnUpdate;
  public $newForeignOnDelete;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $oldData
   * @param  array  $newData
   */
  public function __construct(array $oldData, array $newData) {
    $this->type                 = 'index';
    $this->action               = 'update';
    $this->table                = $oldData['table'];
    $this->column               = $oldData['column'];
    $this->oldName              = $oldData['name'];
    $this->oldMethod            = $oldData['type'];
    $this->oldDropMethod        = 'drop' . ucfirst($this->oldMethod);
    $this->oldForeign           = array_get($oldData, 'foreign', FALSE);
    $this->oldForeignConnection = array_get($oldData, 'foreign_data.connection');
    $this->oldForeignTable      = array_get($oldData, 'foreign_data.table');
    $this->oldForeignColumn     = array_get($oldData, 'foreign_data.column');
    $this->oldForeignName       = array_get($oldData, 'foreign_data.name');
    $this->oldForeignOnUpdate   = array_get($oldData, 'foreign_data.options.onUpdate');
    $this->oldForeignOnDelete   = array_get($oldData, 'foreign_data.options.onDelete');
    $this->newName              = $newData['name'];
    $this->newMethod            = $newData['type'];
    $this->newDropMethod        = 'drop' . ucfirst($this->newMethod);
    $this->newForeign           = array_get($newData, 'foreign', FALSE);
    $this->newForeignConnection = array_get($newData, 'foreign_data.connection');
    $this->newForeignTable      = array_get($newData, 'foreign_data.table');
    $this->newForeignColumn     = array_get($newData, 'foreign_data.column');
    $this->newForeignName       = array_get($newData, 'foreign_data.name');
    $this->newForeignOnUpdate   = array_get($newData, 'foreign_data.options.onUpdate');
    $this->newForeignOnDelete   = array_get($newData, 'foreign_data.options.onDelete');
    $this->migration            = "alter_{$this->oldMethod}_from_{$this->column}_column_in_{$this->table}_table_" . time();
  }

}
