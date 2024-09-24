<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\TimezoneService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeZoneService = app(TimezoneService::class);

        $timezones = $timeZoneService->getTimeZones();

        $maxUsers = 20;

        User::factory()->count($maxUsers)->create([
            'time_zone' => function () use ($timezones) {
                return $timezones[array_rand($timezones)];
            },
        ]);
    }


}
