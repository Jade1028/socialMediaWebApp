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
            -'user_id1' is the foreign key in friend table that references the id of the user
        2nd: The user is the user_id2
            -'user_id2' is the foreign key in friend table that references the id of the user            
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


    // Check if the authenticated user and this user are friends
    public function isFriend($userId){
        return Friend::where(function($query) use ($userId){
            $query->where('user_id1', auth()->id())
                  ->where('user_id2', $userId)
                  ->where('status', 'accepted');
                  
        })->orWhere(function($query) use ($userId){
            $query->where('user_id1', $userId)
                  ->where('user_id2', auth()->id())
                  ->where('status', 'accepted');  
        })->exists();
    }
    

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    
    /*
        The users can have many messages
        sentMessages: The user is the sender
        receivedMessages: The user is the receiver
    */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }


    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }


    /*
        Get all groupchats the user is a member of
        A user can be a member of many group chats
    */
    public function groupChats()
    {
        return $this->belongsToMany(Groupchat::class, 'group_chat_members')
            ->withPivot('role')
            ->withTimestemps();
    }


    /*
        Get all group chats created by this user
    */
    public function createdGroupChats()
    {
        return $this->hasMany(Groupchat::class, 'created_by');
    }


    /*
        Get all group chat messages sent by this user
    */
    public function groupChatMessages()
    {
        return $this->hasMany(Groupchat_message::class, 'sender_id');
    }

}
