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
    return view('start');
});

Route::get('/logout', function () {

    auth()->logout();

    return view('start');
});



Route::get('/test', function () {
    return 'bravo';
})->middleware('auth');

//Groupe de route API
// TODO : déplacer dans fichier api.php et utiliser passport de Laravel pour authentification
Route::group(['prefix' => 'api-test',  'middleware' => ['api','cors',] ], function() {
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

    /*
        Créer toutes les routes standard sauf :
            - create (affiche form création)
            - edit (affiche form édition)
    */
    Route::resource('tasks', 'TaskController', ['except' => ['create', 'edit']]);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
