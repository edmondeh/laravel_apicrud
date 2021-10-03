<?php

namespace App\Services;

use App\Interfaces\AuthenticationServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function loginUser($attr)
    {
        return Auth::attempt($attr);
    }

    public function createUser($attr)
    {
//        User::create([
//            'first_name' => $attr['first_name'],
//            'last_name' => $attr['last_name'],
//            'password' => $attr['password'],
//            'email' => $attr['email']
//        ]);

        return User::create($attr);
    }

    public function createToken($user)
    {
        return $user->createToken('API Token')->plainTextToken;
    }
}
