<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function all();

    public function findById($userId);

    public function store($request);

    public function update(Request $request, $id);

    public function delete($id);
}
