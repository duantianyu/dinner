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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'DinnerController@create');
Route::get('dinner', 'DinnerController@index');
Route::get('dinner/index', 'DinnerController@index');
Route::get('dinner/create', 'DinnerController@create');
Route::post('dinner/store', 'DinnerController@store');
Route::get('dinner/show', 'DinnerController@show');
Route::get('dinner/export', 'DinnerController@export');
//Route::get('dinner/update_date', 'DinnerController@update_date');
//Route::resource('dinner', 'DinnerController');

