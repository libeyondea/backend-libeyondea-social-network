<?php

namespace App\Models;

use App\Traits\PaginationScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, PaginationScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
    {
        return $this->hasMany(Follower::class, 'user_id', 'id');
    }

    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id', 'id');
    }

    public function getAvatarUrlAttribute()
    {
        return config('app.img_url') . '/' . $this->avatar;
    }

    public function getIsFollowingAttribute()
    {
        return !!$this->followers()->where('follower_id', auth()->user()->id)->first();
    }
}
