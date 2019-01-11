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
Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login')->middleware('cors');
Route::get('/stories/{id}', 'API\StoryController@view')->middleware('cors');
Route::get('/stories', 'API\StoryController@getAll')->middleware('cors');
Route::group(['middleware' => ['cors', 'auth:api']], function(){
  Route::resource('/story', 'API\StoryController');
  Route::resource('/category', 'API\CategoryController');
});