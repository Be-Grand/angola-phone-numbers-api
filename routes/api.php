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


Route::get('get-info/{phone}', 'PhoneController@info');



Route::group(['middleware' => ['jwt.roles'], 'prefix' => 'admin'], function() {
  Route::get('phones', 'PhoneController@get');
  Route::post('create-phone', 'PhoneController@create');
  Route::put('update-phone', 'PhoneController@update');
  Route::delete('delete-phone', 'PhoneController@destroy');

});