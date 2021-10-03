<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
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
        $token = $this->authService->createToken($user);

        // Return success response
        return $this->success($user, "Success", $token);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
