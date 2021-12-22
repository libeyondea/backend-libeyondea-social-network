<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Carbon\Carbon;

class AuthController extends Controller
{
    use ApiResponser;

    public function signin(Request $request)
    {
        $credentials = $request->only(['user_name', 'password']);

        if (!auth()->attempt($credentials)) {
            return $this->respondBadRequest('Incorrect username or password');
        }

        $tokenResult = auth()->user()->createToken('Personal Access Token');

        return $this->respondSuccess([
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->accessToken->created_at)->addMinutes(config('sanctum.expiration'))
        ]);
    }

    public function signout()
    {
        auth()->user()->tokens()->delete();
        return $this->respondSuccess('Signout success');
    }

    public function me()
    {
        $user = User::findOrFail(auth()->user()->id);
        return $this->respondSuccess(new UserResource($user));
    }
}
