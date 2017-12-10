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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('user','Admin\UserController');

Route::get('user/{use_id}', 'Admin\UserController@show');

Route::post('/search','Admin\SearchController@index');

Route::get('{user_id}/profile','Admin\SearchController@show');

Route::resource('relation','Admin\RelationController');
