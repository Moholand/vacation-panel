<?php

namespace App\Traits;

trait VacationSearch
{
  // Search in the username column - notice user comes with eager loading
  public function scopeSearchInAuthor($builder)
  {
    $builder->when(request()->search && request()->search !== null, function($query) {
      $query->whereHas('user', function($nested_query) {
          $nested_query->where('name', 'LIKE', '%' . request()->search . '%');
      });
    });
  }

  public function scopeSearchInTitle($builder)
  {
    $builder->when(request()->search && request()->search !== null, function($query) {
      $query->where('title', 'LIKE', '%' . request()->search . '%');
    });
  }
}