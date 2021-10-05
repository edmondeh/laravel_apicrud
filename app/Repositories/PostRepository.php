<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::all();
    }

    public function allWithUser()
    {
        return Post::with('user')
            ->get()
            ->makeVisible('user');
    }

    public function findById($id)
    {
        return Post::where('id', $id)
            ->with('user')
            ->get()
            ->makeVisible('user');
    }

    public function store($request)
    {
        if ($request->has('user_id')) {
            $user = User::findOrFail($request->user_id);
        };

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => isset($user->id) ? $user->id : auth()->user()->id,
        ]);

        //$post->user()->associate($user);

        return $post->makeVisible('user');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update($request->all());

        return $post->makeVisible('user');
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if (is_null($post))
            return null;

//        return Post::destroy($id);
        return $post->delete();
    }
}
