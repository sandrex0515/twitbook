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
Auth::routes();

// Route::get('/home', 'TaskController@homes')->name('home');
// Route::get('/home', 'TaskController@index');
Route::get('/home', 'TaskController@showPost');
Route::post('/home', 'TaskController@storePost');
Route::post('/home/delete', 'TaskController@deletePost');
Route::post('/home/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('home/update', 'TaskController@updatePost');
Route::post('home/like', 'TaskController@likePost');
Route::get('tasks', 'TaskController@index');
Route::get('tasks/{id}', 'TaskController@show');
Route::post('tasks', 'TaskController@store');

Route::get('tasks', 'TaskController@authenticate');
// Route::prefix('auth')->group(function(){

Route::get('tasks/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('tasks/login', 'Auth\LoginController@login')->name('login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// });

Route::put('tasks/{id}', 'TaskController@update');
Route::delete('tasks/{id}', 'TaskController@delete');