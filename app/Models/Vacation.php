<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'request_message', 'from_date', 'to_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
