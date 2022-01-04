<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
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
            return $this->respondError(
                'Invalid credentials',
                [
                    'user_name' => ['Incorrect username or password'],
                    'password' => ['Incorrect username or password']
                ],
                422
            );
        }

        $tokenResult = auth()->user()->createToken('Personal Access Token');

        return $this->respondSuccess([
            'token' => $tokenResult->plainTextToken,
            //'token_type' => 'Bearer',
            //'expires_at' => Carbon::parse($tokenResult->accessToken->created_at)->addMinutes(config('sanctum.expiration'))
        ]);
    }

    public function signup(SignupRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return $this->respondSuccess($user);
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
