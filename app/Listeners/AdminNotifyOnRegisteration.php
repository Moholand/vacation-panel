<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\UserRegisteredNotification;

class AdminNotifyOnRegisteration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $admin = User::where('isAdmin', true)->first();

        $admin->notify(new UserRegisteredNotification($event->user));
    }
}
