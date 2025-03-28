<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;

class TableUpdated {

  use SerializesModels;

  public $type;
  public $action;
  public $oldName;
  public $newName;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param  array  $data
   */
  public function __construct(array $data) {
    $this->type      = 'table';
    $this->action    = 'update';
    $this->oldName   = strtolower($data['oldName']);
    $this->newName   = strtolower($data['newName']);
    $this->migration = "rename_{$this->oldName}_table_" . time();
  }

}
