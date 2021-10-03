<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Api\LoginPostRequest;
use App\Http\Requests\Auth\Api\RegisterPostRequest;
use App\Interfaces\AuthenticationServiceInterface;
use App\Models\User;
use App\Traits\JsonResponeses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use JsonResponeses;

    private $authService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authService = $authenticationService;
    }

    public function login(LoginPostRequest $request)
    {
        // Validatet attributes
        $attr = $request->validated();

        // Attempt to login the user
        if (!$this->authService->loginUser($attr))
            return $this->error(null, 'Credentials not match', 401);

        // Create api token
        $token = auth()->user()->createToken('API Token')->plainTextToken;

        // Return success response
        return $this->success(null, "Success", $token);
    }

    public function register(RegisterPostRequest $request)
    {
        // Validatet attributes
        $attr = $request->validated();

        // Create User
        $user = $this->authService->createUser($attr);

        // Check if user is created
        if (is_null($user))
            return $this->error($user, "Error");

        // Create api token
        //$token = $this->authService->createToken($user);

        // Return success response
        return $this->success($user, "Success");
    }

    public function logout()
    {
        // Delete Api Tokens
        auth()->user()->tokens()->delete();

        // Return success response
        return $this->success(null, "Tokens Revoked");
    }
}
