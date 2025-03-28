<?php

use Illuminate\Support\Facades\Route;
use PittacusW\DatabaseManager\Controllers\ViewController;
use PittacusW\DatabaseManager\Controllers\DataController;
use PittacusW\DatabaseManager\Controllers\TableController;
use PittacusW\DatabaseManager\Controllers\ModelController;

/*
|-------------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if (app()->environment('local')) {
  Route::prefix('database-manager')
       ->as('database-manager.')
       ->group(function() {
         Route::get('/', [
          ViewController::class,
          'app'
         ])
              ->name('admin');
         Route::get('views/{view}', [
          ViewController::class,
          'views'
         ]);
         Route::get('connections/tables', 'ConexionController@tables');
         Route::get('connections/columns', 'ConexionController@columns');
         Route::get('indexes/types', 'IndiceController@types');

         Route::apiResource('tables', TableController::class);
         Route::apiResource('columns', 'ColumnaController', [
          'only' => [
           'index',
           'store',
           'update',
           'destroy'
          ]
         ]);
         Route::apiResource('indexes', 'IndiceController', [
          'only' => [
           'index',
           'store',
           'update',
           'destroy'
          ]
         ]);
         Route::apiResource('data', DataController::class);
         Route::apiResource('migrations', 'MigracionController', [
          'only' => [
           'index',
           'show',
           'store'
          ]
         ]);
         Route::apiResource('seeds', 'SemillaController', [
          'only' => [
           'index',
           'show',
           'store'
          ]
         ]);
         Route::apiResource('models', ModelController::class);
         Route::get('plans', 'ModuloPlanController@index');
         Route::get('certifications', 'ModuloCertificacionController@index');
         Route::put('business/upload/{id}', 'ImportController@index');
         Route::put('business/activate/{id}', 'EmpresaController@activate');
         Route::put('business/deactivate/{id}', 'EmpresaController@deactivate');
         Route::put('business/certificate/{id}', 'EmpresaController@certificate');
         Route::put('business/resetpassword/{id}', 'EmpresaController@resetpassword');
         Route::apiResource('business', 'EmpresaController', [
          'only' => [
           'index',
           'store',
           'update',
           'destroy'
          ]
         ]);
         Route::post('users/profile/{id?}', 'UsuarioController@profile');
         Route::apiResource('users', 'UsuarioController', [
          'only' => [
           'index',
           'store',
           'update',
           'destroy'
          ]
         ]);
         Route::apiResource('logs', 'LogController', [
          'only' => [
           'index',
           'show',
           'destroy'
          ]
         ]);
       });
}