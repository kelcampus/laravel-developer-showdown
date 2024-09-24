<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model = User::class;

    public function findById($userId)
    {
        return $this->model::find($userId);
    }

    public function save(User $user)
    {
        return $user->save();
    }
}


