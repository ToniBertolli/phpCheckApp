<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('admin/instances', 'Admin\AdminViewsController@instances');
Route::get('admin/instances/{instance}', 'Admin\AdminViewsController@instance');
Route::get('admin/endpoints/{endpoint}', 'Admin\AdminViewsController@endpoint');

Route::get('/', 'FrontDashboardController@index');
Route::get('/instances/{instance}', 'FrontDashboardController@endpoints');
Route::get('/latest-errors', 'FrontDashboardController@endpointErrors');


//Route::resource('admin/dashboards', 'Admin\DashboardViewsController')->only(['index', 'show', 'edit']);

//    Route::resource('domains', 'DomainController')->only(['index', 'show', 'store', 'update', 'destroy']);
//    Route::resource('procedures', 'ProcedureController')->only(['index', 'show', 'store', 'update', 'destroy']);
//    Route::resource('logs', 'LogController')->only(['index', 'show', 'store', 'update', 'destroy']);
