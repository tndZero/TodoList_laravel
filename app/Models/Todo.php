<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 'content', 'completed', 'completed_by', 'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
