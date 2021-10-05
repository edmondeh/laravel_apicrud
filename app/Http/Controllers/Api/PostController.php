<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostStoreRequest;
use App\Http\Requests\Api\Post\PostUpdateRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Traits\JsonResponeses;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use JsonResponeses;

    private $postRepo;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepo = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->postRepo->allWithUser();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        // Store post to database
        $post = $this->postRepo->store($request);

        // Check if post is stored if no return error response
        if (is_null($post))
            return $this->error(null, "Some error happend.");

        // In the end return success response
        return $this->success($post, "Post with name: $post->title created sucessfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check if id is null
        if (is_null($id))
            return $this->error(null, 'Some error happend.');

        // Get the post from database
        $post = $this->postRepo->findById($id);

        // Check if the post exists
        if (is_null($post))
            return $this->error(null, 'Some error happend.');

        // In the end return success response
        return $this->success($post, "Success");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        // Update post to database
        $post = $this->postRepo->update($request, $id);

        // Check if post is updated if no return error response
        if (is_null($post))
            return $this->error(null, "Some error happend.");

        // In the end return success response
        return $this->success($post, "Post with $post->name updated sucessfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if id is null
        if (is_null($id))
            return $this->error(null, 'Some error happend.');

        // Delete the post from database
        $result = $this->postRepo->delete($id);

        // Check if user is deleted if no return error
        if($result == 0)
            return $this->error(null, "Some error happend.");

        // In the end return success reponse
        return $this->success(null, "Post with $id deleted successfully.");
    }
}
