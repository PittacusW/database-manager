<?php

namespace PittacusW\DatabaseManager\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use PittacusW\DatabaseManager\DatabaseManagerServiceProvider;

class TestCase extends Orchestra {

  protected function setUp()
  : void {
    parent::setUp();

    Factory::guessFactoryNamesUsing(
     fn(string $modelName) => 'PittacusW\\DatabaseManager\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
    );
  }

  protected function getPackageProviders($app) {
    return [
     DatabaseManagerServiceProvider::class,
    ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
