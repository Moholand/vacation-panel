<?php

namespace App\Services;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class DateService
{
  // Convert to gerogrian date manually -- any better idea??
  public function solarToGerogrian($fromDate, $toDate) : array
  {
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