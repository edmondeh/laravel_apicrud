<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CommentRepositoryInterface;
use App\Traits\JsonResponeses;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use JsonResponeses;

    private $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepo = $commentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        if (is_null($postId))
            return $this->error(null, "Error");

        $comments = $this->commentRepo->all($postId);

        if (is_null($comments))
            return $this->error(null, "Error");

        return $this->success($comments, "Message");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postId)
    {
        if (is_null($postId))
            return $this->error(null, "Error");

        $request->validate([
            'body' => 'required'
        ]);

        $comment = $this->commentRepo->store($request, $postId);

        if (is_null($comment))
            return $this->error(null, "Error");

        return $this->success($comment, "Message");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($postId, $commentId)
    {
        if (is_null($postId) && is_null($commentId))
            return $this->error(null, "Error");

        $comment = $this->commentRepo->findById($postId, $commentId);

        if (is_null($comment))
            return $this->error(null, "Error");

        return $this->success($comment, "Message");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId, $commentId)
    {
        if (is_null($postId) && is_null($commentId))
            return $this->error(null, "Error");

        $request->validate([
            'body' => 'required'
        ]);

        $comment = $this->commentRepo->update($request, $postId, $commentId);

        if (is_null($comment))
            return $this->error(null, "Error");

        return $this->success($comment, "Message");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId, $commentId)
    {
        if (is_null($postId) && is_null($commentId))
            return $this->error(null, "Error");

        $comment = $this->commentRepo->delete($postId, $commentId);

        if ($comment == 0)
            return $this->error(null, "Error");

        return $this->success($comment, "Message");
    }
}
