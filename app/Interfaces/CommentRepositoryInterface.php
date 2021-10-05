<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CommentRepositoryInterface
{
    public function all($postId);

    public function findById($postId, $commentId);

    public function store($request, $postId);

    public function update(Request $request, $postId, $commentId);

    public function delete($postId, $commentId);
}
