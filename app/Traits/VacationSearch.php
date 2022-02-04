<?php

namespace App\Traits;

trait VacationSearch
{
  public function scopeSearchInAuthor($builder)
  {
    $builder->when(request()->search && request()->search !== null, function($query) {
      // Search in the username column - notice user comes with eager loading
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