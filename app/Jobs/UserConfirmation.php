<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\UserConfirmationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $isVerified;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $isVerified)
    {
        $this->user = $user;
        $this->isVerified = $isVerified;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new UserConfirmationNotification($this->isVerified));
    }
}
