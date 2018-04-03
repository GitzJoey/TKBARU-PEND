<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::bind('id', function ($id) {
        if (!is_numeric($id)) {
            return Hashids::decode($id)[0];
        } else {
            return $id;
        }
    });

    Route::group(['prefix' => 'get', 'middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('readAll', 'CompanyController@readAll')->name('api.get.company.readall');
        });

        Route::group(['prefix' => 'unit'], function () {
            Route::get('readAll', 'UnitController@readAll')->name('api.get.unit.readall');
        });

        Route::group(['prefix' => 'lookup'], function() {
            Route::get('byCategory/{category}', 'LookupController@getLookupByCategory')->name('api.get.lookup.bycategory');
        });
    });

    Route::group(['prefix' => 'post', 'middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'unit'], function () {
            Route::post('save', 'UnitController@store')->name('api.post.unit.save');
            Route::post('edit/{id}', 'UnitController@update')->name('api.post.unit.edit');
            Route::post('delete/{id}', 'UnitController@delete')->name('api.post.unit.delete');
        });
    });
});