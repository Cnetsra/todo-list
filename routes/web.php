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

Route::get('/{any}', 'ItemController@index')->where('any', '.*');

Route::get('/get_all', 'ItemController@get_all');
Route::post('store', 'ItemController@store');
Route::post('update', 'ItemController@update');
Route::put('change-completed', 'ItemController@change_completed');
Route::delete('destroy', 'ItemController@destroy');