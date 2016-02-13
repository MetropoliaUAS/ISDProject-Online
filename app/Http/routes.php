<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api'], function () {
    Route::post('products/create', 'ProductsController@store');
    Route::post('samplings/create', 'SamplingsController@store');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('samplings/show/{productId}', 'SamplingsController@show');
        Route::get('products', 'ProductsController@apiIndex');
    });
});

Route::auth();

//Webpages for guests
Route::get('/', 'WelcomeController@index');
Route::get('/about', 'WelcomeController@about');

//Webpages for users
Route::get('/home', 'HomeController@home');
Route::get('/profile', 'HomeController@profile');

Route::get('/products', 'ProductsController@index');
Route::post('/products', 'ProductsController@check');
Route::post('/products/add', 'ProductsController@add');
Route::post('/products/delete/{id}', 'ProductsController@delete');
Route::get('/products/{id}', 'ProductsController@show');
Route::post('/products/{id}', 'ProductsController@update');

Route::get('/sensors', 'SensorsController@index');
Route::get('/sensors/types/{id}', 'SensorsController@show_types');
Route::get('/sensors/{id}', 'SensorsController@show');