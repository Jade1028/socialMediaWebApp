<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    /*
        The friend tables use the primary key of the user table
        Therefore, the friend belongs to a user table 
    */
    public function user1(){
        return $this->belongsTo(User::class, 'user_id1');
    }
    
    public function user2(){
        return $this->belongsTo(User::class, 'user_id2');
    }
}
