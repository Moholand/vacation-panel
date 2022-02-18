<?php

namespace App\Traits\User;

trait UserSearch
{
  public function scopeSearchInUser($builder)
  {
    $builder->when(request()->search && request()->search !== null, function($query) {
      
      $query->where('name', 'LIKE', '%' . request()->search . '%')
            ->orWhere('email', 'LIKE', '%' . request()->search . '%');

    });
  }
}