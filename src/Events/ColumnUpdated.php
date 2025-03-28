<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class ColumnUpdated extends Column {

  use SerializesModels;

  public $type;
  public $action;
  public $table;
  public $oldName;
  public $oldMethod;
  public $oldParams;
  public $oldDefault;
  public $oldNullable;
  public $newName;
  public $newMethod;
  public $newParams;
  public $newDefault;
  public $newNullable;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $oldData
   * @param  array  $newData
   */
  public function __construct(array $oldData, array $newData) {
    $this->type        = 'column';
    $this->action      = 'update';
    $this->table       = $oldData['table'];
    $this->oldName     = $oldData['name'];
    $this->oldMethod   = $oldData['type'];
    $this->oldParams   = $this->getParams($oldData);
    $this->oldDefault  = $this->getDefault($oldData);
    $this->oldNullable = $this->getNullable($oldData);
    $this->newName     = $newData['name'];
    $this->newMethod   = $newData['type'];
    $this->newParams   = $this->getParams($newData);
    $this->newDefault  = $this->getDefault($newData);
    $this->newNullable = $this->getNullable($newData);
    $this->migration   = "alter_{$this->oldName}_column_in_{$this->table}_table_" . time();
  }

}
