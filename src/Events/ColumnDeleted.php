<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class ColumnDeleted extends Column {

  use SerializesModels;

  public $type;
  public $action;
  public $table;
  public $name;
  public $method;
  public $params;
  public $default;
  public $nullable;
  public $position;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $data
   */
  public function __construct(array $data) {
    $this->type      = 'column';
    $this->action    = 'delete';
    $this->table     = $data['table'];
    $this->name      = $data['name'];
    $this->method    = $data['type'];
    $this->params    = $this->getParams($data);
    $this->default   = $this->getDefault($data);
    $this->nullable  = $this->getNullable($data);
    $this->position  = $this->getPosition($data);
    $this->migration = "drop_{$this->name}_column_to_{$this->table}_table_" . time();
  }

}
