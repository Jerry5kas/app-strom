<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        return $post->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $request->body,
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'body' => 'required|string',
        ]);

        $comment->update(['body' => $request->body]);

        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }

}
