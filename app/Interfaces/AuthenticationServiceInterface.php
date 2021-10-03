<?php

namespace App\Interfaces;

interface AuthenticationServiceInterface
{
    public function createUser($attr);

    public function createToken($user);
}
