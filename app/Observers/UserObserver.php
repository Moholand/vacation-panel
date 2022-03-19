<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\UserRegisteredNotification;

class UserObserver
{
    public function created(User $user)
    {
        // Send notification to admin
        if($admins = User::where('isAdmin', true)->get()) {
            foreach($admins as $admin) {
                $admin->notify(new UserRegisteredNotification($user));
            }
        }
    }
}
