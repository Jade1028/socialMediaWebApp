<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat_message extends Model
{
    use HasFactory;


    protected $table = 'group_chat_messages';



    protected $fillable = [
        'group_chat_id', 
        'sender_id',
        'message'
    ];

    
    /*
        Get the group chat this message belongs to
    */
    public function groupChat()
    {
        return $this->belongsTo(Groupchat::class, 'group_chat_id');
    }


    /*
        Get the sender of this message
    */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
