<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Validation\ValidationException;

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
        } catch (ValidationException $th) {
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

    // DION: the method below works with both PATCH and PUT
    // PATCH /api/todo-list or PUT /api/todo-list
    public function update(Request $request, $id)
    {

        // Normally this is done with:
        // $db = model::find($id)
        // but as a simple simulation we'll use dummy data with $id - 1
        $data = $this->getDummyData();
        $index = (int)$id - 1;

        if (!isset($data[$index])) {
            return response()->json(['message' => "Data ID $id tidak ditemukan."], 404);
        }

        // simulating editing a data with a simple 2 field change as shown in
        // getDummyEdit() and merging the artificial data with request 
        // to keep the logic similar
        $currentData = $data[$index];
        $request->merge($this->getDummyEdit());

        try {

            // uses "sometimes" so it works when there is an empty field
            $validated = $request->validate([
                'title'       => 'sometimes|required|string|max:100',
                'description' => 'sometimes|required|string|max:255',
                'deadline'    => 'sometimes|required|date_format:Y-m-d',
                'priority'    => 'sometimes|required|in:low,medium,high',
                'status'      => 'sometimes|required|in:pending,in_progress,completed',
            ]);

            // normally we update the data first with
            // $model->update($validated)
            // but since this is a simulation we don't really have that.
            $updatedData = array_merge($currentData, $validated);

        } catch (ValidationException $th) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors'  => $th->validator->errors(),
                'attempted_data' => $request->all()
            ], 422);
        }


        return response()->json([
            'message' => "Update Sukses",
            'source'  => 'Data diambil dari getDummyEdit()',
            'old_data' => $currentData,
            'new_data' => $updatedData
        ], 200);
    }

    private function getDummyData(){
        return [
            [
                "id" => 1,
                "title" => "Tugas membuat ayam krispi",
                "description" => "Membuat ayam krispi yang sangat mirip atau identik dengan ayam krispi kfc",
                "deadline" => "2026-03-17",
                "priority" => "high",
                "status" => "in_progress"
            ],
            [
                "id" => 2,
                "title" => "Tugas membuat Nasi goreng kediri",
                "description" => "membuat nasi goreng seenak penjual nasi goreng di depan bandung collection",
                "deadline" => "2026-03-18",
                "priority" => "medium",
                "status" => "pending"
            ]
        ];
    }

    private function getDummyEdit()
    {
        return [
            "status" => "completed",
            "description" => "AYAM KRIPSI EDIT, HEHEHEHA!",
            "deadline" => "2026-03-17"
        ];
    }
}
