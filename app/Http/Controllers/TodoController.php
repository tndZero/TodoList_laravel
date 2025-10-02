<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with(['user', 'completer', 'comments.user'])->orderByDesc('created_at')->get();
        return view('main', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $todo = Todo::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return redirect()->back();
    }

    public function update(Request $request, Todo $todo)
    {
    // Authorization will be handled in the view for now
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $todo->update(['content' => $request->content]);
        return redirect()->back();
    }

    public function destroy(Todo $todo)
    {
    // Authorization will be handled in the view for now
        $todo->delete();
        return redirect()->back();
    }

    public function checklist(Request $request, Todo $todo)
    {
        // Only allow checklist if not already completed
        if (!$todo->completed) {
            $todo->completed = true;
            $todo->completed_by = Auth::id();
            $todo->completed_at = now();
            $todo->save();
        }
        return redirect()->back();
    }
}
