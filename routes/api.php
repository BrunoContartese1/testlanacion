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

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*=======================================================
                        LOGIN ROUTES
    ========================================================*/
    Route::post('/logout', 'AuthController@logout');


    Route::prefix('Administration')->group(function() {

        /*=======================================================
                            Profiles
        ========================================================*/
        Route::resource('Profiles', 'Administration\Profiles\ProfilesController')->except(['create', 'edit']);
        Route::post('Profiles/Search', 'Administration\Profiles\ProfilesController@search');
        Route::get('profiles/permissionGroups', 'Administration\Profiles\ProfilesController@permissionsGroups');
        Route::post('profiles/{profile}/updatePermissions', 'Administration\Profiles\ProfilesController@updatePermissions');

        /*=======================================================
                            End Profiles
        ========================================================*/


        /*=======================================================
                            Usuarios
        ========================================================*/
        Route::resource('users', 'Administration\Users\UsersController')->except(['create', 'edit']);


        /*=======================================================
                            Fin Usuarios
        ========================================================*/



    });

});



