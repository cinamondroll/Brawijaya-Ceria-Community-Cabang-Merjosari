<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoListController;

//RAKHMAN: GET
Route::get('/todo-list', [ToDoListController::class, 'index']);
Route::get('/todo-list/{id}', [ToDoListController::class, 'show']);
//HERY: POST
Route::post('/todo-list', [ToDoListController::class, 'store']);
//DION: PUT and PATCH
Route::put('/todo-list/{id}', [ToDoListController::class, 'update']);
Route::patch('/todo-list/{id}', [ToDoListController::class, 'update']);
//NAYA: DETELE
Route::delete('/todo-lists/{id}', [ToDoListController::class, 'destroy']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

