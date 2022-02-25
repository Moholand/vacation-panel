<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Vacation\VacationFilter;
use App\Traits\Vacation\VacationSearch;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacation extends Model
{
    use HasFactory, SoftDeletes, VacationSearch, VacationFilter, Sluggable;

    protected $fillable = [
        'title', 
        'request_message', 
        'type', 
        'mode', 
        'from_date', 
        'to_date',
        'from_hour', 
        'to_hour'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Verta($value)->formatDifference(); //Also can use another format (Verta($value)->format('H:i Y-n-j'))
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
                'source' => 'title'
            ]
        ];
    }
}
