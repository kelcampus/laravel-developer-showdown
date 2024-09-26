<?php

use App\Console\Commands\SendUserUpdatesToAPI;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendUserUpdatesToAPI::class)->everyTwoMinutes();
