<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class EnforceDeviceLimit
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Fetch all active sessions for this user, ordered by last_activity descending
        $activeSessions = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();

        // If there are 2 or more sessions, we keep the most recent 1, and delete the rest.
        // The newly created session for the current login will be the 2nd one.
        if ($activeSessions->count() >= 2) {
            $sessionsToDelete = $activeSessions->slice(1)->pluck('id');
            
            \Illuminate\Support\Facades\DB::table('sessions')
                ->whereIn('id', $sessionsToDelete)
                ->delete();
        }
    }
}
