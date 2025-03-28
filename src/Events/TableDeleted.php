<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;
use PittacusW\DatabaseManager\Models\Admin\Modelo;

class TableDeleted {

  use SerializesModels;

  public $type;
  public $action;
  public $name;
  public $sql;
  public $migration;

  /**
   * Create a new event instance.
   *
   * @param $name
   */
  public function __construct($name) {
    $this->type      = 'table';
    $this->action    = 'delete';
    $this->name      = strtolower($name);
    $this->sql       = preg_replace([
                                     '/\n/',
                                     '/\s+/',
                                     '/\`/'
                                    ], [
                                     ' ',
                                     ' ',
                                     ''
                                    ], collect(\DB::select("SHOW CREATE TABLE {$name}"))
                                     ->pluck('Create Tabla')
                                     ->first());
    $this->migration = "drop_{$this->name}_table_" . time();
  }
}
