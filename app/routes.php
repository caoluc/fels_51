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

Route::get('/', 'HomeController@index');
Route::get('login', 'SessionController@create');
Route::post('login', 'SessionController@store');
Route::get('register', 'UserController@create');
Route::post('register', 'UserController@store');
Route::get('users/{id}', 'UserController@show');
Route::get('logout', 'SessionController@destroy');
Route::resource('user', 'UserController');

Route::resource('word', 'WordController');
Route::get('list', 'WordController@listWord');
Route::post('list', 'WordController@listWord');
Route::resource('category', 'CategoryController');
Route::resource('lesson', 'LessonController');
Route::get('question/{categoryId}', 'LessonController@question');
Route::post('question/{categoryId}', 'LessonController@question');
Route::get('question/{answerSheetId}/{oldAnswerId}', 'LessonController@submit');
Route::get('result/{lessonId}', 'LessonController@result');
