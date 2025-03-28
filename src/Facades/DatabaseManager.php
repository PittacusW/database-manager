<?php

namespace PittacusW\DatabaseManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PittacusW\DatabaseManager\DatabaseManager
 */
class DatabaseManager extends Facade {

  protected static function getFacadeAccessor()
  : string {
    return \PittacusW\DatabaseManager\DatabaseManager::class;
  }
}
