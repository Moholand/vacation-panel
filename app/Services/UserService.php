<?php

namespace App\Services;

class UserService
{
  public function getTeammatesIds() : array
  {
    $teammate_ids = [];

    $teammates = auth()->user()->department()->with(['employees'])
    ->get()
    ->pluck('employees')
    ->collapse();

    foreach ($teammates as $teammate) {
        array_push($teammate_ids, $teammate->id);
    }

    return $teammate_ids;
  }
}