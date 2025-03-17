<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class LogLastLogin
{
    /**
     * Create the event listener.
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->last_login_at = now();
        $user->save();
    }
}
