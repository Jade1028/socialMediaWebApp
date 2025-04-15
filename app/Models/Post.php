<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id', 'image_url'];
    use HasFactory;

    /*
        The post use primary of user 
        Therefore, the post belongs to a user
    */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /*
        The post can have many comments
    */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /*
        The post can have many likes
    */
    public function likes(){
        return $this->hasMany(Like::class);
    }

}
