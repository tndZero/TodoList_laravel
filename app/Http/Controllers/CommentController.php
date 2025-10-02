<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $todoId)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'todo_id' => $todoId,
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('comments', 'public');
        }

        \App\Models\Comment::create($data);
        return redirect()->back();
    }
}
