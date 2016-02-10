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

Route::post('/products/create', 'ProductsController@store');

Route::post('/samplings/create', 'SamplingsController@store');
Route::get('/samplings/show/{productId}', 'SamplingsController@show');

Route::get('/', function () {
    return view('welcome');
});
