<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('likes')->orderBy('created_at', 'desc')->paginate(5);
        return view('pages.index', ['posts' => $posts]);
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show($postId)
    {
        $post = Post::with('comments.user')->findOrFail($postId);
        return view('pages.post', compact('post'));
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function toggleLike($postId)
    {
        $user = Auth::user();

        // Check if the user already liked the post
        if ($user->likes()->where('post_id', $postId)->exists()) {
            // Unlike the post
            $user->likes()->where('post_id', $postId)->delete();
            return back()->with('success', 'Post unliked.');
        } else {
            // Like the post
            $user->likes()->create(['post_id' => $postId]);
            return back()->with('success', 'Post liked.');
        }
    }

    public function addComment(Request $request, $postId)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    $post = Post::findOrFail($postId);

    $post->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->input('content'),
    ]);

    return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully!');
}
}
