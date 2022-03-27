<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Vacation;
use App\Notifications\VacationCreatedOnHeadNotification;

class VacationObserver
{
    public function created(Vacation $vacation)
    {
        // Send notification to head of department
        $currentDepartment = $vacation->user()->with('department')->get()->pluck('department')->first();

        $headOfDepartment = User::findOrFail($currentDepartment->head_id);

        $headOfDepartment->notify(new VacationCreatedOnHeadNotification($vacation));
    }
}
