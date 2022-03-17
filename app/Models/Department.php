<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'head_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Define Relations for this model.
     */
    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'head_id', 'id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
