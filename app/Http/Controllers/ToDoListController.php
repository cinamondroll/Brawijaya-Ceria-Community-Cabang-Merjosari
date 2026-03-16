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
            'message' => "Todo list {$validated['title']} berhasil dihapus",
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
}
