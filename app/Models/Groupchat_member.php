<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat_member extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_chat_id',
        'user_id', 
        'role'
    ];


    public function groupMessage()
    {
        return $this->hasMany(Groupchat_message::class, 'group_chat_id');
    }
}
