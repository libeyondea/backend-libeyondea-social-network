<?php

namespace App\Models;

use App\Traits\PaginationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, PaginationScope;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function childrenComments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
