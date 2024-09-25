<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Models\UserUpdate;
use App\Repositories\UserUpdateRepository;

// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class QueueUserUpdate // implements ShouldQueue
{
    // use InteractsWithQueue;

    /**
     * Handle the event.
     */
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
