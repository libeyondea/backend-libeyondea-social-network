<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    use ApiResponser;

    public function like($slug)
    {
        $comment = Comment::where('slug', $slug)->firstOrFail();
        $likeCheck = CommentLike::where('user_id', auth()->user()->id)->where('comment_id', $comment->id)->first();
        if (!$likeCheck) {
            $commentLike = new CommentLike();
            $commentLike->user_id = auth()->user()->id;
            $commentLike->comment_id = $comment->id;
            $commentLike->save();
            return $this->respondSuccess([
                'id' => $commentLike->comment->id,
                'slug' => $commentLike->comment->slug
            ]);
        } else {
            return $this->respondBadRequest('Liked');
        }
    }

    public function unlike($slug)
    {
        $comment = Comment::where('slug', $slug)->firstOrFail();
        $likeCheck = CommentLike::where('user_id', auth()->user()->id)->where('comment_id', $comment->id)->firstOrFail();
        $likeCheck->delete();
        return $this->respondSuccess([
            'id' => $likeCheck->comment->id,
            'slug' => $likeCheck->comment->slug
        ]);
    }
}
