<?php

namespace App\Console\Commands;

use App\Repositories\UserUpdateRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendUserUpdatesToAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:send-user-updates-to-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user updates to the API.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userUpdateRepository = app(UserUpdateRepository::class);
        $updates = $userUpdateRepository->getBatch(limit: 1000);

        if ($updates->isEmpty()) {
            $this->info('No user updates to send.');
            return;
        }

        // Prepare the payload for the API
        $payload = $this->mountDataPayload($updates);

        // Send the API request
        $response = Http::get(route('fake_api_batch'), $payload);

        if ($response->successful()) {
            // Delete the processed records from the database
            dd('deu certo'); // parei aqui

            $userUpdateRepository->deleteUpdates($updates);
            $this->info('Successfully sent user updates to the API.');

            return 0;
        }

        $this->error('Failed to send user updates to the API. Response: ' . $response->body());
        return 1;
    }

    private function mountDataPayload($updates)
    {
        return [
            'batches' => [[
                'subscribers' => $updates->map(function ($update) {
                    return [
                        'email' => $update->email,
                        'name' => $update->firstname . ' ' . $update->lastname,
                        'time_zone' => $update->time_zone,
                    ];
                })->toArray(),
            ]],
        ];
    }
}
