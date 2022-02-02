<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Services\DateService;
use Hekmatinasser\Verta\Verta;

trait VacationFilter
{
  public function scopeFilterByStatus($builder)
  {
    $builder->when(request()->vacation_status && request()->vacation_status !== null, function($query) {
      $query->where('status', request()->vacation_status);
    });
  }

  public function scopeFilterByDate($builder)
  {
    $builder->when(request()->fromDate && request()->toDate, function($query) {
      //convert dates to gerogrian -- return array of from and to dates
      $dates = $this->dateToGerogrian(request()->fromDate, request()->toDate);

      $query->whereBetween('updated_at', [$dates['fromDate'], $dates['toDate']]);
    });
  }

  // Move it to right place
  public function dateToGerogrian($fromDate, $toDate) : array
  {
    // Convert to gerogrian date manually -- any better idea??
    $fromDateGerogrian = implode('-', Verta::getGregorian(
        explode('/',$fromDate)[0],
        explode('/',$fromDate)[1],
        explode('/',$fromDate)[2]
    ));
    
    $toDateGerogrian = implode('-', Verta::getGregorian(
        explode('/',$toDate)[0],
        explode('/',$toDate)[1],
        explode('/',$toDate)[2]
    ));

    // Delete the effect of clock
    $fromDateStandard = Carbon::createFromFormat('Y-m-d', $fromDateGerogrian)->startOfDay();
    $toDateStandard = Carbon::createFromFormat('Y-m-d', $toDateGerogrian)->endOfDay();

    return [
      'fromDate' => $fromDateStandard,
      'toDate' => $toDateStandard
    ];
  }
}