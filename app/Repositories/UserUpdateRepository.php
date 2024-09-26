<?php

namespace App\Repositories;

use App\Models\UserUpdate;

class UserUpdateRepository
{
    protected $model = UserUpdate::class;

    public function getBatch(int $limit = 1000)
    {
        return $this->model::limit($limit)->get();
    }

    public function findByEmail(string $email)
    {
        return $this->model::where('email', '=', $email)->first();
    }

    public function updateOrCreate(array $data = [])
    {
        $userUpdate = $this->findByEmail($data['email']);
        if (!$userUpdate) {
            return $this->model::create($data);
        }

        return $this->model::where('id', '=', $userUpdate->id)->update($data);
    }

    public function deleteUpdates($userUpdates): void
    {
        foreach ($userUpdates as $userUpdate) {
            $this->model::destroy($userUpdate->id);
        }
    }
}


