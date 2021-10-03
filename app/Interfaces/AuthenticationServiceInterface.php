<?php

namespace App\Interfaces;

interface AuthenticationServiceInterface
{
    public function loginUser($attr);

    public function createUser($attr);

    public function createToken($user);
}
