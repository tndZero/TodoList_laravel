<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'todo_id', 'content', 'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
