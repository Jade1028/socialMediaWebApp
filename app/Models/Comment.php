<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /*
        The comment tables use the primary key of the user and post
        Therefore, the comment belongs to a user and post
    */

    protected $fillable = ['post_id', 'user_id', 'content'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
