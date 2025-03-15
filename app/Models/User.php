<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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

    /*
         The users can have many posts
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    /*
        The users can have many friends
        1st: The user is the user_id1
        2nd: The user is the user_id2
    */
    public function friends(){
        return $this->hasMany(Friend::class, 'user_id1');
    }

    public function friendsOf(){
        return $this->hasMany(Friend::class, 'user_id2');
    }

    /**
     * Check if the authenticated user has sent a friend request to the user with the given id
     */
    public function hasSentFriendRequestTo($userId){

        /**
         * $query is the query builder instance automatic passed by Laravel's Eloquent methods like where()
         */
        return Friend::where(function($query) use ($userId){
            $query->where('user_id1', auth()->id())
            ->where('user_id2', $userId);
        })->orWhere(function($query) use ($userId){
            $query->where('user_id1', $userId)
            ->where('user_id2', auth()->id());  
        })->exists();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
