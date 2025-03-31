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
    public function groupMessage()
    {
        return $this->hasMany(Groupchat_message::class, 'group_chat_id');
    }


    /*
        Get the user this member belongs to
    */
}
