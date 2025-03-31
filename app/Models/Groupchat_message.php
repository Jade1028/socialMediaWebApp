<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat_message extends Model
{
    use HasFactory;

    protected $fillable = ['group_chat_id', 'sender_id', 'message'];


}
