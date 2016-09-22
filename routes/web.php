<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/', 'RateController@index');

Route::get('addBelow', 'RelationController@add');
Route::post('addBelow', 'RelationController@addProcess');

Route::get('lookBelow', 'RelationController@look');
Route::get('seekBelow/{id}', 'RelationController@seek');

Route::get('setRate', 'RateController@set');
Route::get('setOtherRate/{id}', 'RateController@set');
Route::post('setRate', 'RateController@setProcess');
Route::post('synchronize', 'RateController@synchronize');
