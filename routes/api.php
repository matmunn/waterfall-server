<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::post('/login', function (Request $request) {
    $creds = [
    "email" => $request->get('email'),
    "password" => $request->get("password")
    ];

    if (Auth::attempt($creds)) {
        $user = User::where('email', $request->email)->first();
        $user->makeVisible('api_token');

        return response($user, 200);
    }

    return response("Error", 401);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/task', 'TaskApiController@createTask');
    Route::patch('/task/{task}', 'TaskApiController@updateTask');
    Route::delete('/task/{task}', 'TaskApiController@deleteTask');
    Route::get('/tasks', 'TaskApiController@getAllTasks');
    Route::get('/tasks/{startDate}/{endDate?}', 'TaskApiController@getTasksByDate');
    Route::patch('/task/{task}/complete', 'TaskApiController@markTaskComplete');
    Route::patch('/task/{task}/incomplete', 'TaskApiController@markTaskIncomplete');

    Route::post('/user', 'UserApiController@createUser');
    Route::patch('/user/{user}', 'UserApiController@updateUser');
    Route::delete('/user/{user}', 'UserApiController@deleteUser');
    Route::get('/users', 'UserApiController@getAllUsers');

    Route::post('/category', 'CategoryApiController@createCategory');
    Route::patch('/category/{category}', 'CategoryApiController@updateCategory');
    Route::delete('/category/{category}', 'CategoryApiController@deleteCategory');
    Route::get('/categories', 'CategoryApiController@getAllCategories');

    Route::post('/client', 'ClientApiController@createClient');
    Route::patch('/client/{client}', 'ClientApiController@updateClient');
    Route::delete('/client/{client}', 'ClientApiController@deleteClient');
    Route::get('/clients', 'ClientApiController@getAllClients');

    Route::post('/note', 'NoteApiController@createNote');
    Route::patch('/note/{note}', 'NoteApiController@updateNote');
    Route::delete('/note/{note}', 'NoteApiController@deleteNote');
    Route::get('/notes', 'NoteApiController@getAllNotes');
});
