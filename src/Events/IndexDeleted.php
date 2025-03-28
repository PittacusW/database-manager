<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class IndexDeleted {

  use SerializesModels;

  public $type;
  public $action;
  public $table;
  public $column;
  public $name;
  public $method;
  public $dropMethod;
  public $foreign;
  public $foreignConnection;
  public $foreignTable;
  public $foreignColumn;
  public $foreignName;
  public $foreignOnUpdate;
  public $foreignOnDelete;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $data
   */
  public function __construct(array $data) {
    $this->type              = 'index';
    $this->action            = 'delete';
    $this->table             = $data['table'];
    $this->column            = $data['column'];
    $this->name              = $data['name'];
    $this->method            = $data['type'];
    $this->dropMethod        = 'drop' . ucfirst($this->method);
    $this->foreign           = array_get($data, 'foreign', FALSE);
    $this->foreignConnection = array_get($data, 'foreign_data.connection');
    $this->foreignTable      = array_get($data, 'foreign_data.table');
    $this->foreignColumn     = array_get($data, 'foreign_data.column');
    $this->foreignName       = array_get($data, 'foreign_data.name');
    $this->foreignOnUpdate   = array_get($data, 'foreign_data.options.onUpdate');
    $this->foreignOnDelete   = array_get($data, 'foreign_data.options.onDelete');
    $this->migration         = "drop_{$this->method}_from_{$this->column}_column_in_{$this->table}_table_" . time();
  }

}
