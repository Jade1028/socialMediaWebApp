<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat_member extends Model
{
    use HasFactory;


    protected $table = 'group_chat_members';


    protected $fillable = [
        'group_chat_id',
        'user_id', 
        'role'
    ];


    /*
        Get the group chat this member belongs to
    */
    public function groupChat()
    {
        return $this->belongsTo(Groupchat::class, 'group_chat_id');
    }


    /*
        Get the user this member belongs to
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
