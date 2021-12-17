<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Follower;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    use ApiResponser;

    public function follow($user_name)
    {
        $following = User::where('user_name', $user_name)->firstOrFail();
        $followingCheck = Follower::where('user_id', $following->id)->where('follower_id', auth()->user()->id)->first();
        if (!$followingCheck) {
            $follower = new Follower();
            $follower->user_id = $following->id;
            $follower->follower_id = auth()->user()->id;
            $follower->save();
            return $this->respondSuccess([
                'id' => $follower->follower->id,
                'user_name' => $follower->follower->user_name
            ]);
        } else {
            return $this->respondBadRequest('Followed');
        }
    }

    public function unfollow($user_name)
    {
        $following = User::where('user_name', $user_name)->firstOrFail();
        $followingCheck = Follower::where('user_id', $following->id)->where('follower_id', auth()->user()->id)->firstOrFail();
        $followingCheck->delete();
        return $this->respondSuccess([
            'id' => $followingCheck->follower->id,
            'user_name' => $followingCheck->follower->user_name
        ]);
    }

    public function followers($user_name)
    {
        $users = User::whereHas('following', function ($q) use ($user_name) {
            $q->where('user_id', User::where('user_name', $user_name)->firstOrFail()->id);
        });
        $usersCount = $users->get()->count();
        $users = $users->pagination();
        return $this->respondSuccessWithPagination(new UserCollection($users), $usersCount);
    }

    public function following($user_name)
    {
        $users = User::whereHas('followers', function ($q) use ($user_name) {
            $q->where('follower_id', User::where('user_name', $user_name)->firstOrFail()->id);
        });
        $usersCount = $users->get()->count();
        $users = $users->pagination();
        return $this->respondSuccessWithPagination(new UserCollection($users), $usersCount);
    }
}
