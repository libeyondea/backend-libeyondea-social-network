<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\ApiResponser;

class CommentController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($slug)
    {
        $comments = Comment::where('post_id', Post::where('slug', $slug)->firstOrFail()->id);
        $commentsCount = $comments->get()->count();
        $comments = $comments->whereNull('parent_id')->pagination();
        return $this->respondSuccessWithPagination(new CommentCollection($comments), $commentsCount);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentRequest $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = auth()->user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->content = $request->content;
        $comment->save();
        return $this->respondSuccess($comment);
    }

    public function destroy($slug)
    {
        $comment = Comment::where('slug', $slug)->firstOrFail();
        $comment->delete();
        return $this->respondSuccess($comment);
    }
}
