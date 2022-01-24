<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'head'];

    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'head', 'id');
    }
}
