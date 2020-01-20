<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api']], function () {
    Route::resource('instances', 'API\InstanceController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('endpoints', 'API\EndpointController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('procedures', 'API\ProcedureController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('fields', 'API\FieldController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('logs', 'API\LogController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('proceduretypes', 'API\EnumController@procedureTypes');
    Route::get('fieldtypes', 'API\EnumController@fieldTypes');
    Route::get('totalResponseTime', 'API\DashboardController@getResponseTime');
    Route::get('totalErrors', 'API\DashboardController@getCurrentErrors');
    Route::get('errorsWeek', 'API\DashboardController@getErrorsWeek');
    Route::get('checksToday', 'API\DashboardController@getChecksToday');
    Route::get('lastKnownError', 'API\DashboardController@getLastKnownError');
    Route::get('serverLoad', 'API\DashboardController@getServerLoad');

    Route::get('deployments/recent', 'API\DeploymentController@getRecentDeployments');
    Route::post('deployments/webhook', 'API\DeploymentController@webhook');
});
