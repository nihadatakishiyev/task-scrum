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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
//list users
Route::get('users', 'UserController@index');

//get single user
Route::get('user/{id}', 'UserController@show');

//create user
Route::post('user', 'UserController@store');

//update user
Route::put('user', 'UserController@store');

//delete user
Route::delete('user/{id}', 'UserController@destroy');


//list projects
Route::get('projects', 'ProjectController@index');

//get single project
Route::get('project/{id}', 'ProjectController@show');

//create project
Route::post('project', 'ProjectController@store');

//update project
Route::put('project', 'ProjectController@store');

//delete project
Route::delete('project/{id}', 'ProjectController@destroy');


//list tasks
Route::get('tasks', 'TaskController@index');

//get single task
Route::get('task/{id}', 'TaskController@show');

//create task
Route::post('task', 'TaskController@store');

//update task
Route::put('task', 'TaskController@store');

//delete task
Route::delete('task/{id}', 'TaskController@destroy');
