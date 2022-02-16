<?php

namespace App\Traits;

use App\Services\DateService;

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

      $dates = (new DateService)->solarToGerogrian(request()->fromDate, request()->toDate);
      $query->whereBetween('updated_at', [$dates['fromDate'], $dates['toDate']]);

    });
  }
}