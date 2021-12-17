<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_name)
    {
        $user = User::where('user_name', $user_name)->firstOrFail();
        return $this->respondSuccess(new UserResource($user));
    }
}
