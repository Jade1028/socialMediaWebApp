<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function edit(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update(['content' => $request->content]);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
