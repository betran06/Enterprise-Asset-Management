<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Cache;

class HandleUserLogout
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
    public function handle(object $event): void
    {
        if ($event->user) {
            // hapus status online
            Cache::forget('user-is-online-' . $event->user->id);

            // OPTIONAL (kalau nanti mau)
            // $event->user->update([
            //     'last_logout_at' => now(),
            // ]);
        }
    }
}
