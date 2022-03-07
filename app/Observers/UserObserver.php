<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Jobs\notifyAdminOnRegisteration;

class UserObserver
{
    public function created(User $user)
    {
        notifyAdminOnRegisteration::dispatch($user);
    }
}
