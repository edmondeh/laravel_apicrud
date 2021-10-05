<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentRepository implements CommentRepositoryInterface
{
    public function all($postId)
    {
        return Post::with(['user' ,'comments'])
            ->where('id', $postId)
            ->get()
            ->makeVisible(['user', 'comments']);
    }

    public function findById($postId, $commentId)
    {
        $post = Post::whereRelation(
            'comments', 'id', '=', $commentId
        )->first();
        if ($post->id != $postId)
            return null;
        if (is_null($post))
            return $post;

        $comment = Comment::with(['user', 'commentable'])->where('id', $commentId)->get();
        if (is_null($comment))
            return $comment;

        return $comment->makeVisible(['user', 'commentable']);
    }

    public function store($request, $postId)
    {
        $post = Post::find($postId);
        if (is_null($post))
            return $post;

        $comment = $post->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->user()->id
        ]);

        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'email' => $comment->user->email
            ]
        ];
    }

    public function update(Request $request, $postId, $commentId)
    {
        $comment = Comment::find($commentId);
        if (is_null($comment))
            return null;
        if ($comment->commentable->id != $postId)
            return null;

        //$post->update($request->all());
        $comment->update($request->all());

        return $comment;
    }

    public function delete($postId, $commentId)
    {
        $comment = Comment::find($commentId);
        if (is_null($comment))
            return null;
        if ($comment->commentable->id != $postId)
            return null;

        return $comment->delete();
    }
}
