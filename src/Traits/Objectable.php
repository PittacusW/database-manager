<?php

namespace PittacusW\DatabaseManager\Traits;

use Riimu\Kit\PHPEncoder\PHPEncoder;
use Illuminate\Support\Facades\Storage;
use PittacusW\DatabaseManager\Models\Objeto;

trait Objectable {

  protected function makeObject($table) {
    Objeto::generate($table);
  }

  protected function deleteObject($table) {
    Objeto::delete($table);
  }

  protected function renameObject($oldTable, $newTable) {
    $this->deleteObject($oldTable);
    config()->set("objects.{$newTable}", config("objects.{$oldTable}", []));
    $config = with(new PHPEncoder())->encode(config('objects'));
    Storage::disk('configs')
           ->put('objects.php', "<?php\r\n\r\nreturn {$config};");
    $this->makeObject($newTable);
  }
}
