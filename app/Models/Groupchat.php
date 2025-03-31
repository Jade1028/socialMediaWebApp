<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat extends Model
{
    use HasFactory;


    protected $table = 'group_chats';

    
    protected $fillable = [
        'name', 
        'description', 
        'created_by'
    ];


    /*
        Get the user who create the group chat
    */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /*
        Get all the members of the group chat
    */
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_chat_members')
            ->withPivot('role')
            ->withTimestamps();
    }


    /*
        Get all messages of the group chat
    */
    public function messages()
    {
        return $this->hasMany(Groupchat_message::class, 'group_chat_id');
    }

    /*
        Check if user is a member of the group chat
        @param int $userId
        @return bool
    */
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }


    /*
        Check if user is an admin of the group chat
        @param int $userId
        @return bool
    */
    public function isAdmin($userId)
    {
        return $this->members()->where('user_id', $userId)
            ->where('role', 'admin')
            ->exists();
    }
}
