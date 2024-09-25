<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BatchUserUpdateController extends Controller
{
    public function updateBatchUsers(Request $request)
    {
        $validated = $this->validate($request);

        // Log each subscriber's update
        foreach ($validated['batches'] as $batch) {
            foreach ($batch['subscribers'] as $subscriber) {
                $this->saveLog($subscriber);
            }
        }

        return response()->json(['success' => true, 'message' => 'Updates logged successfully.']);
    }

    private function validate($request)
    {
        return $request->validate([
            'batches' => 'required|array',
            'batches.*.subscribers' => 'required|array',
            'batches.*.subscribers.*.email' => 'required|email',
            'batches.*.subscribers.*.first_name' => 'required|string',
            'batches.*.subscribers.*.last_name' => 'required|string',
            'batches.*.subscribers.*.time_zone' => 'required|string',
        ]);
    }

    private function saveLog($subscriber)
    {
        Log::info(sprintf(
            "[%s] firstname: %s, lastname: %s, timezone: '%s'",
            $subscriber['email'],
            $subscriber['first_name'],
            $subscriber['last_name'],
            $subscriber['time_zone']
        ));
    }
}
