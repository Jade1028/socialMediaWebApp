<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $posts = Post::with(['likes', 'user'])->orderBy('created_at', 'desc')->paginate(10);
        $users = User::paginate(10);
        return view('admin', compact('posts', 'users'));
    }
}
