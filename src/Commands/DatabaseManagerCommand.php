<?php

namespace PittacusW\DatabaseManager\Commands;

use Illuminate\Console\Command;

class DatabaseManagerCommand extends Command {

  public $signature = 'database-manager';

  public $description = 'My command';

  public function handle()
  : int {
    $this->comment('All done');

    return self::SUCCESS;
  }
}
