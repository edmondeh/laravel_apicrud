<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\UserStoreRequest;
use App\Http\Requests\Api\User\UserUpdateRequest;
use App\Traits\JsonResponeses;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonResponeses;

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource($this->userRepo->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        // Validatet attributes
        $attr = $request->validated();

        // Store user to database
        $user = $this->userRepo->store($attr);

        // Check if user is stored
        if (is_null($user))
            return $this->error(null, 'Some error happend.');

        // In the end return user resource
        return new UserResource($user);
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

        // Get the user from database
        $user = $this->userRepo->findById($id);

        // Check if the user exists
        if (is_null($user))
            return $this->error(null, 'Some error happend.');

        // In the end return user resource
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        // Validatet attributes
        $attr = $request->validated();

        // Update user to database
        $user = $this->userRepo->update($attr, $id);

        // Check if user is updated
        if (is_null($user))
            return $this->error(null, 'Some error happend.');

        // In the end return user resource
        return new UserResource($user);
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

        // Delete the user
        $user = $this->userRepo->delete($id);

        // Check if the user is deleted
        if ($user == 0)
            return $this->error(null, 'Some error happend.');

        // In the end return success response
        return $this->success(null, "User deleted.");
    }
}
