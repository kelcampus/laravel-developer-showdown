<?php

use App\Console\Commands\SendUserUpdatesToAPI;
use Illuminate\Support\Facades\Schedule;

// 50 / 60 = 1.2
Schedule::command(SendUserUpdatesToAPI::class)->everyMinute();
