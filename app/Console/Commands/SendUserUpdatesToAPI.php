<?php

namespace App\Console\Commands;

use App\Repositories\UserUpdateRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        // 50 req / 60 min => 1,2 min.
        // 60 / 1.2 = 50 * 1000 = 50000

        // Add a delay of 12 seconds (0.2 minutes)
        sleep(12);

        $userUpdateRepository = app(UserUpdateRepository::class);
        $updates = $userUpdateRepository->getBatch(limit: 1000);

        if ($updates->isEmpty()) {
            $this->info('No user updates to send.');
            return;
        }

        $payload = $this->mountDataPayload($updates);

        $status = $this->sendBatchUserUpdatesToProvider($payload);

        if ($status) {
            $userUpdateRepository->deleteUpdates($updates);
            $this->info('Successfully sent user updates to the API.');
            return 0;
        }

        return 1;
    }

    private function mountDataPayload($updates)
    {
        return [
            'batches' => [[
                'subscribers' => $updates->map(function ($update) {
                    return [
                        'email' => $update->email,
                        'fullname' => $update->firstname . ' ' . $update->lastname,
                        'time_zone' => $update->time_zone,
                    ];
                })->toArray(),
            ]],
        ];
    }

    public function sendBatchUserUpdatesToProvider($payload): bool
    {
        try {
            foreach ($payload['batches'] as $batch) {
                foreach ($batch['subscribers'] as $subscriber) {
                    $this->saveLog($subscriber);
                }
            }
        } catch (\Throwable $th) {
            $this->error('Failed to send user updates to the API. Response: ' . $th->getMessage());
            return false;
        }

        return true;
    }

    private function saveLog(array $subscriber): void
    {
        Log::info(sprintf(
            "[%s] fullname: %s, timezone: '%s'",
            $subscriber['email'],
            $subscriber['fullname'],
            $subscriber['time_zone']
        ));
    }
}
