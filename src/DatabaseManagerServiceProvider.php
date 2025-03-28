<?php

namespace PittacusW\DatabaseManager;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class DatabaseManagerServiceProvider extends PackageServiceProvider {

  public function configurePackage(Package $package)
  : void {
    /*
     * This class is a Package Service Provider
     *
     * More info: https://github.com/spatie/laravel-package-tools
     */
    $package
     ->name('database-manager')
     ->hasConfigFile()
     ->hasViews()
     ->hasAssets()
     ->hasRoute('database-manager')
     ->hasInstallCommand(function(InstallCommand $command) {
       $command->publishAssets()
        ->copyAndRegisterServiceProviderInApp();
     });
  }
}
