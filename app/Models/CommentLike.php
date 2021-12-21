<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(Post::class, 'comment_id', 'id');
    }
}
