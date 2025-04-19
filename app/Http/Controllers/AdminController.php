<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'posts_page');
        $users = User::where('is_banned', false)->orWhere('is_banned', null)->orderBy('updated_at', 'desc')->paginate(5, ['*'], 'users_page');
        $bannedUsers = User::where('is_banned', true)->orderBy('updated_at', 'desc')->paginate(5, ['*'], 'banned_users_page');
        return view('admin', compact('posts', 'users', 'bannedUsers'));
    }

    public function deletePost($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    public function banUser($id){
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();
        return redirect()->back()->with('success', 'User banned successfully.');
    }
}
