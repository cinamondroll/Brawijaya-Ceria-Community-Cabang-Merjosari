<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoListController;

//NAYA: DETELE
Route::delete('/todo-lists/{id}', [ToDoListController::class, 'destroy']);
//HERY: POST
Route::post('/todo-list', [ToDoListController::class, 'store']);
//RAKHMAN: GET
Route::get('/todo-list', [ToDoListController::class, 'index']);
Route::get('/todo-list/{id}', [ToDoListController::class, 'show']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

