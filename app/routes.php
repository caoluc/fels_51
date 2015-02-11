<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', ['as' => '/', 'uses' => 'HomeController@index']);
Route::get('login', ['as' => 'login', 'uses' => 'UserController@login']);
Route::post('plogin', ['as' => 'plogin', 'uses' => 'UserController@postLogin']);
Route::get('register', ['as' => 'register', 'uses' => 'UserController@getRegister']);
Route::post('register', ['as' => 'register', 'uses' => 'UserController@postRegister']);
Route::post('profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
Route::resource('user', 'UserController');