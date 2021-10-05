<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PostRepositoryInterface
{
    public function all();

    public function allWithUser();

    public function findById($userId);

    public function store($request);

    public function update(Request $request, $id);

    public function delete($id);
}
