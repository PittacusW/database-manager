<?php

namespace PittacusW\DatabaseManager\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

trait Migratable {

  protected function makeMigration($event) {
    $filename  = $this->getFileName($event->migration);
    $migration = $this->getMigrationPath($filename);
    Storage::disk('migrations')
           ->put($filename, view('layouts.migration', compact('event'))->render());
    Artisan::call('format', ['path' => $migration]);
    Artisan::call('migrate:do', ['connection' => current_connection()->nombre]);
  }

  protected function getMigrationPath($filename) {
    $namespace = strtolower(current_connection()->namespace);

    return database_path("migrations/{$namespace}/{$filename}");
  }

  protected function getFileName($migration) {
    return date('Y_m_d_His') . "_{$migration}.php";
  }
}
