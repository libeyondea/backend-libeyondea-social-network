<?php

namespace App\Models;

use App\Traits\PaginationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, PaginationScope;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'post_id', 'id');
    }

    public function getIsLikedAttribute()
    {
        return !!$this->postLikes->where('user_id', auth()->user()->id)->first();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }
}
