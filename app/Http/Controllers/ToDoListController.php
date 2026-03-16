<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToDoListController extends Controller
{
    // HERY: Pake dengan format ini aja nanti
    // POST /api/todo-list
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer|min:1',
                'title' => 'required|string|max:100',
                'description' => 'required|string|max:255',
                'deadline' => 'required|date_format:Y-m-d',
                'priority' => 'required|in:low,medium,high',
                'status' => 'required|in:pending,in_progress,completed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $th->validator->errors(),
            ], 422);
        }

        return response()->json([
            'message' => "Todo list {$validated['title']} berhasil ditambahkan",
            'data' => $validated,
        ], 201);
    }

    //Naya: ini masih dummy data, nanti sambung sambungin lah sama data create (kalo bisa)
    public function destroy($id)
    {
        return response()->json([
            "message" => "Todo-list {$id} berhasil dihapus"
        ]);
    }

    public function index()
    {
        $todos = $this->getDummyData();

        return response()->json([
            'message' => 'Berhasil mengambil semua data Todo list',
            'data' => $todos
        ]);

    }

    public function show($id)
    {

        $todos = $this->getDummyData();

        $simpanDataTodo = null;

        foreach ($todos as $todo) {
            if($todo['id'] == $id){
                $simpanDataTodo = $todo;
                break;
            }
        }

        if ($simpanDataTodo != null) {
            return response()->json([
                'message' => 'Todo list berhasil ditemukan',
                'data' => $simpanDataTodo
            ],200);
        }

        return response()->json([
            "message" => "Todo list dengan id {$id} tidak ditemukan"
        ], 404);
    }

    private function getDummyData(){
        return [
            [
                "id" => 1,
                "title" => "Tugas membuat ayam krispi",
                "description" => "Membuat ayam krispi yang sangat mirip atau identik dengan ayam krispi kfc",
                "deadline" => "2026-3-17",
                "priority" => "high",
                "status" => "in_progress"
            ],
            [
                "id" => 2,
                "title" => "Tugas membuat Nasi goreng kediri",
                "description" => "membuat nasi goreng seenak penjual nasi goreng di depan bandung collection",
                "deadline" => "2026-3-18",
                "priority" => "medium",
                "status" => "pending"
            ]
        ];
    }
}
