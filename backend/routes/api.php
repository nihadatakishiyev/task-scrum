<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//
//});
//
Route::resource('users', 'UserController');
Route::resource('projects', 'ProjectController');
Route::resource('tasks', 'TaskController');
Route::resource('comments', 'CommentController');
Route::resource('ups', 'UserPermissionController');
Route::resource('als', 'ActivityLogController');

Route::post('/login', 'auth\LoginController@login');
Route::post('/register', 'auth\RegisterController@register');

Route::middleware('auth:api')->get('/details', 'UserController@details');

//Route::get('/user/{id}/deadlines', 'UserController@deadlines');

//Route::middleware('auth:api')->group(function (){
//    Route::resource('users', 'UserController');
//    Route::resource('projects', 'ProjectController');
//    Route::resource('tasks', 'TaskController');
//    Route::resource('comments', 'CommentController');
//    Route::resource('ups', 'UserPermissionController');
//    Route::resource('als', 'ActivityLogController');
//
//    Route::get('/details', 'UserController@details');
//
////    Route::get('/user/{id}/deadlines', 'UserController@deadlines');
//});
