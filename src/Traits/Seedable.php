<?php

namespace PittacusW\DatabaseManager\Traits;

use PittacusW\DatabaseManager\Models\Admin\Semilla;

trait Seedable {

  protected function makeSeed($table = NULL) {
    Semilla::generate('iseed', $table);
  }

}
