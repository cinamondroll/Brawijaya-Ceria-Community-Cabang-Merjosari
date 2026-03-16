<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToDoListController extends Controller
{


    //Naya: ini masih dummy data, nanti sambung sambungin lah sama data create (kalo bisa)
    public function destroy($id)
{
    $todo = [
        "id" => "1",
        "title" => "Mengerjakan laporan praktikum",
        "description" => "Menyelesaikan laporan praktikum TIS",
        "deadline" => "2026-03-20",
        "priority" => "high",
        "status" => "pending"
    ];

    return response()->json([
        "message" => "List {$todo['title']} deleted successfully"
    ]);
}
}
