<?php

namespace App\Services;

use App\Interfaces\AuthenticationServiceInterface;
use App\Models\User;

class AuthenticationService implements AuthenticationServiceInterface
{
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
        return $user->createToken('tokens')->plainTextToken;
    }
}
