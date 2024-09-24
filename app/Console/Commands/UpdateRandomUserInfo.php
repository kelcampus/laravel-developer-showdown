<?php

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use App\Support\TimezoneService;
use Illuminate\Console\Command;

class UpdateRandomUserInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-random-user-info {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Random User Info';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeZoneService = app(TimezoneService::class);
        $userRepository = app(UserRepository::class);

        $userId = $this->argument('userId');
        $user = $userRepository->findById($userId);

        if (!$user) {
            $this->error('User not found.');
            return 1;
        }

        $user->firstname = fake()->firstName();
        $user->lastname = fake()->lastName();
        $user->time_zone = $timeZoneService->getRandomTimeZone();


        $userRepository->save($user);

        $this->info('User information updated successfully.');
        return 0;
    }
}
