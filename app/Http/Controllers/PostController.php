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
        return view('home', ['posts' => $posts]);
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully.');
    }

    public function show($postId)
    {
        $post = Post::with('comments.user')->findOrFail($postId);
        return view('pages.post', compact('post'));
    }

    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('pages.edit', compact('post'));
    }

    public function destroy(Post $post)
{
    if (Auth::id() !== $post->user_id) {
        abort(403, 'Unauthorized');
    }
    $post->delete();
    return redirect()->route('home')->with('success', 'Post deleted successfully.');
}

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('home')->with('success', 'Post updated successfully.');
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
