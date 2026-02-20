<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        // Example of storing a todo item
        $todo = \App\Models\todo::create($request->all());

        return response()->json($todo, 201);
    }

    public function update(Request $request, $id)
    {
        // Example of updating a todo item
        $todo = \App\Models\todo::findOrFail($id);
        $todo->update($request->all());

        return response()->json($todo, 200);
    }

    public function destroy($id)
    {
        // Example of deleting a todo item
        \App\Models\todo::destroy($id);

        return response()->json(null, 204);
    }
}
