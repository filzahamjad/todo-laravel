<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TodoController;

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


  
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
     
Route::group(['middleware' => ['auth:api']], function () { 
    Route::post('addToList', [TodoController::class, 'store']);
    Route::post('updateTodo', [TodoController::class, 'update']);
    Route::get('deleteTodo/{id}', [TodoController::class, 'destroy']);
    Route::get('showTodo/{id}', [TodoController::class, 'show']);
    Route::get('showAllTodo/{pageNumber}', [TodoController::class, 'showAll']);
});


