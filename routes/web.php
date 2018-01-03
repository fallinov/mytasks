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

//Groupe de route API
Route::prefix('api')->group(function() {
    /*
    RESTful Resource Controllers : https://laravel.com/docs/5.0/controllers#restful-resource-controllers
    Création automatique des routes de base avec :
            Route::resource('tasks', 'TaskController');

       Pour voir les routes actives :
            php artisan route:list

        +--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
        | Domain | Method    | URI                   | Name          | Action                                      | Middleware   |
        +--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
        |        | GET|HEAD  | /                     |               | Closure                                     | web          |
        |        | GET|HEAD  | api/tasks             | tasks.index   | App\Http\Controllers\TaskController@index   | web          |
        |        | POST      | api/tasks             | tasks.store   | App\Http\Controllers\TaskController@store   | web          |
        |        | GET|HEAD  | api/tasks/create      | tasks.create  | App\Http\Controllers\TaskController@create  | web          |
        |        | GET|HEAD  | api/tasks/{task}      | tasks.show    | App\Http\Controllers\TaskController@show    | web          |
        |        | PUT|PATCH | api/tasks/{task}      | tasks.update  | App\Http\Controllers\TaskController@update  | web          |
        |        | DELETE    | api/tasks/{task}      | tasks.destroy | App\Http\Controllers\TaskController@destroy | web          |
        |        | GET|HEAD  | api/tasks/{task}/edit | tasks.edit    | App\Http\Controllers\TaskController@edit    | web          |
        |        | GET|HEAD  | api/user              |               | Closure                                     | api,auth:api |
        +--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
    */
    Route::resource('tasks', 'TaskController');
});