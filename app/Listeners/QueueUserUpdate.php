<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Repositories\UserUpdateRepository;

class QueueUserUpdate
{
    public function handle(UserUpdated $event): void
    {
        $userUpdateRepository = app(UserUpdateRepository::class);

        $userUpdateRepository->updateOrCreate([
            'email' => $event->user->email,
            'firstname' => $event->user->firstname,
            'lastname' => $event->user->lastname,
            'time_zone' => $event->user->time_zone,
        ]);
    }
}
