<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Follower;
use App\Models\Image;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = new Post();
        if ($request->has('user')) {
            $posts = $posts->whereHas('user', function ($q) use ($request) {
                $q->where('user_name', $request->user);
            });
        } else {
            $posts = $posts->whereIn('user_id', Follower::where('follower_id', auth()->user()->id)->pluck('user_id'));
        }
        $postsCount = $posts->get()->count();
        $posts = $posts->pagination();
        return $this->respondSuccessWithPagination(new PostCollection($posts), $postsCount);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return $this->respondSuccess(new PostResource($post));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreatePostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->slug = Str::random(33);
        $post->content = $request->content;
        if ($post->save()) {
            foreach ($request->images as $image) {
                $image = new Image();
                $image->post_id = $post->id;
                $image->name = $image['name'];
                $image->save();
            }
        }
        return $this->respondSuccess($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     * @param  string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, $slug)
    {
        $post = Post::where('slug', $slug)->where('user_id', auth()->user()->id)->firstOrFail();
        $post->content = $request->content;
        if ($post->save()) {
            foreach ($request->images as $image) {
                $image = new Image();
                $image->post_id = $post->id;
                $image->name = $image->name;
                $image->save();
            }
        }
        return $this->respondSuccess($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->where('user_id', auth()->user()->id)->firstOrFail();
        $post->delete();
        return $this->respondSuccess($post);
    }
}
