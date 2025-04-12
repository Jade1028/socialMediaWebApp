<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $posts = Post::with(['likes', 'user'])->orderBy('created_at', 'desc')->paginate(5, ['*'], 'posts_page');
        $users = User::paginate(5, ['*'], 'users_page');
        return view('admin', compact('posts', 'users'));
    }

    public function deletePost($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }
}
