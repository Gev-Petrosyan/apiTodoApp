<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    
    public function get() {
        $todos = Todo::where('user_id', Auth::id())->get();
        return response()->json([
            'status' => 'success',
            'todos' => $todos
        ]);
    }

    public function getById($id) {
        $todo = Todo::find($id);
        return (empty($todo) || $todo->user_id != Auth::id()) ?
        response()->json([
            'status' => 'error',
            'todo' => 'Todo dont found'
        ]):
        response()->json([
            'status' => 'success',
            'todo' => $todo
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'description' => ['required', 'max:255']
        ]);

        Todo::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'active' => 1
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'id_todo' => ['required'],
            'description' => ['required', 'max:255']
        ]);

        $todo = Todo::find($request->id_todo);
        if ($todo->user_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'error' => 'Its todo of another user'
            ]);
        }

        $todo->description = $request->description;
        $todo->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function active(Request $request) {
        $request->validate([
            'id_todo' => ['required']
        ]);

        $todo = Todo::find($request->id_todo);
        if ($todo->user_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'error' => 'Its todo of another user'
            ]);
        }

        $todo->active = ($todo->active == 0) ? 1 : 0;
        $todo->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function delete(Request $request) {
        $request->validate([
            'id_todo' => ['required']
        ]);

        $todo = Todo::find($request->id_todo);
        if ($todo->user_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'error' => 'Its todo of another user'
            ]);
        }

        $todo->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

}
