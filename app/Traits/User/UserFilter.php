<?php

namespace App\Traits\User;

trait UserFilter
{
  public function scopeFilterByDepartment($builder)
  {
    $builder->when(request()->department_id && request()->department_id !== null, function($query) {
      $query->where('department_id', request()->department_id);
    });
  }

  public function scopeFilterByStatus($builder)
  {
    $builder->when(request()->user_status && request()->user_status !== null, function($query) {
      $query->where('isVerified', request()->user_status === 'confirm' ? 1 : 0);
    });
  }
}