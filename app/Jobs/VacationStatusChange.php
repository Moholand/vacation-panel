<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class VacationStatusChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $vacation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Vacation $vacation)
    {
        $this->user = $user;
        $this->vacation = $vacation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new UserNotification($this->vacation));
    }
}
