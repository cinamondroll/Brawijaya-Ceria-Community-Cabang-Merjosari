<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoListController;

//NAYA: DETELE
Route::delete('/todo-lists/{id}', [ToDoListController::class, 'destroy']);
//HERY: POST
Route::post('/todo-list', [ToDoListController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

