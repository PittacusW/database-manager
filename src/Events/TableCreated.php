<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class TableCreated {

  use SerializesModels;

  public $type;
  public $action;
  public $name;
  public $softDelete;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $data
   */
  public function __construct(array $data) {
    $this->type       = 'table';
    $this->action     = 'create';
    $this->name       = strtolower(array_get($data, 'name'));
    $this->softDelete = (bool) array_get($data, 'softdelete', FALSE);
    $this->migration  = "create_{$this->name}_table_" . time();
  }
}