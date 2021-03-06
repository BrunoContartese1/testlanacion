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
Route::post('/login', 'AuthController@login')->name('login');


Route::group(['middleware' => 'auth:api'], function() {

    /*=======================================================
                        LOGIN ROUTES
    ========================================================*/
    Route::post('/logout', 'AuthController@logout');


    Route::prefix('Administration')->group(function() {

        /*=======================================================
                            Profiles Routes
        ========================================================*/
        Route::resource('Profiles', 'Administration\Profiles\ProfilesController')->except(['create', 'edit']);
        Route::post('Profiles/Search', 'Administration\Profiles\ProfilesController@search');
        Route::get('profiles/permissionGroups', 'Administration\Profiles\ProfilesController@permissionsGroups');

        Route::post('profiles/{profile}/updatePermissions', 'Administration\Profiles\ProfilesController@updatePermissions');

        /*=======================================================
                            End Profiles Routes
        ========================================================*/


        /*=======================================================
                            Users Routes
        ========================================================*/
        Route::resource('users', 'Administration\Users\UsersController')->except(['create', 'edit']);


        /*=======================================================
                            End Users Routes
        ========================================================*/

        /*=======================================================
                            Sensors Routes
        ========================================================*/
        Route::resource('sensors', 'Administration\SensorsController')->except(['create', 'edit']);
        Route::get('sensors/{sensor}/nearestSensors/{quantity}', 'Administration\SensorsController@nearestSensors');

        /*=======================================================
                            End Sensors Routes
        ========================================================*/
     });

});



