<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class Business {

  use SerializesModels;

  public $business;
  public $repository;
  public $domain;
  public $email;
  public $path;
  public $table;
  public $dbGeneral;
  public $dbUnica;
  public $dbRoot;
  public $dbUsername;
  public $dbPassword;
  public $configPath;
  public $configContent;
  public $themePath;
  public $themeContent;
  public $envPath;
  public $envContent;
  public $logoOldPath;
  public $logoNewPath;
  public $root;
  public $representatives;

  public function setBaseAttributes($business) {
    $this->business   = $business;
    $this->repository = env('APP_REPOSITORY');
    $this->domain     = env('APP_DOMAIN');
    $this->email      = "{$this->business->alias}@{$this->domain}";
    $this->path       = "/home/erp/{$this->business->alias}";
    $this->table      = $business->getTable();
  }

  public function setDatabaseAttributes() {
    $this->dbGeneral  = "erp_general";
    $this->dbUnica    = "erp_{$this->business->alias}";
    $this->dbRoot     = "erp_root";
    $this->dbUsername = "erp_{$this->business->alias}";
    $this->dbPassword = hash('md2', uniqid(mt_rand(1, mt_getrandmax()), TRUE));
  }

  public function setConfigAttributes() {
    $config              = collect([
                                    'dbHost'       => 'localhost',
                                    'dbGeneral'    => $this->dbGeneral,
                                    'dbUnica'      => $this->dbUnica,
                                    'dbUsername'   => $this->dbUsername,
                                    'dbPassword'   => $this->dbPassword,
                                    'idEmpresas'   => $this->business->getKey(),
                                    'hashKey'      => hash('md5', uniqid(mt_rand(1, mt_getrandmax()), TRUE)),
                                    'saltKey'      => hash('sha256', uniqid(mt_rand(1, mt_getrandmax()), TRUE)),
                                    'tokenKey'     => hash('sha384', uniqid(mt_rand(1, mt_getrandmax()), TRUE)),
                                    'certKey'      => hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), TRUE)),
                                    'cipherMethod' => env('APP_CIPHER_METHOD')
                                   ]);
    $configPatch         = collect([
                                    'search'  => $config->keys()
                                                        ->all(),
                                    'replace' => $config->values()
                                                        ->all()
                                   ]);
    $this->configPath    = str_finish($this->path, '/config/config.php');
    $this->configContent = str_replace($configPatch->get('search'), $configPatch->get('replace'), Storage::disk('stubs')
                                                                                                         ->get('config.stub'));
  }

  public function setThemeAttributes($colors) {
    $theme              = collect([
                                   'primaryColor'     => strtok(array_get($colors, 'primary'), '.'),
                                   'primaryVariation' => substr(strrchr(array_get($colors, 'primary'), '.'), 1),
                                   'accentColor'      => strtok(array_get($colors, 'accent'), '.'),
                                   'accentVariation'  => substr(strrchr(array_get($colors, 'accent'), '.'), 1),
                                   'warnColor'        => strtok(array_get($colors, 'warn'), '.'),
                                   'warnVariation'    => substr(strrchr(array_get($colors, 'warn'), '.'), 1),
                                  ]);
    $themePatch         = collect([
                                   'search'  => $theme->keys()
                                                      ->all(),
                                   'replace' => $theme->values()
                                                      ->all()
                                  ]);
    $this->themePath    = str_finish($this->path, '/libs/js/theme.js');
    $this->themeContent = str_replace($themePatch->get('search'), $themePatch->get('replace'), Storage::disk('stubs')
                                                                                                      ->get('theme.stub'));
  }

  public function setEnvAttributes() {
    $this->envPath    = str_finish($this->path, '/libs/js/env.js');
    $this->envContent = Storage::disk('stubs')
                               ->get('env.stub');
  }

  public function setLogoAttributes() {
    $this->logoOldPath = storage_path("app/public/logos/{$this->business->getKey()}.png");
    $this->logoNewPath = str_finish($this->path, '/img/logos/logo.png');
  }

  public function setRootAttributes($data) {
    $this->root = collect($data);
  }

  public function setRepresentativesAttributes($data) {
    $this->representatives = collect($data);
  }
}
