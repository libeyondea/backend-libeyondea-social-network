<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    use ApiResponser;

    public function like($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $likeCheck = PostLike::where('user_id', auth()->user()->id)->where('post_id', $post->id)->first();
        if (!$likeCheck) {
            $postLike = new PostLike();
            $postLike->user_id = auth()->user()->id;
            $postLike->post_id = $post->id;
            $postLike->save();
            return $this->respondSuccess([
                'id' => $postLike->post->id,
                'slug' => $postLike->post->slug
            ]);
        } else {
            return $this->respondBadRequest('Liked');
        }
    }

    public function unlike($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $likeCheck = PostLike::where('user_id', auth()->user()->id)->where('post_id', $post->id)->firstOrFail();
        $likeCheck->delete();
        return $this->respondSuccess([
            'id' => $likeCheck->post->id,
            'slug' => $likeCheck->post->slug
        ]);
    }
}
