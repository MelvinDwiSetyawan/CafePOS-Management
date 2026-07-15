<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $activity, string $description = null): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'description' => $description,
        ]);
    }
}
