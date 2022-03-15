<?php

namespace App\Models;

use App\Models\Vacation;
use PhpParser\Node\Attribute;
use App\Traits\User\UserFilter;
use App\Traits\User\UserSearch;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserSearch, UserFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'department_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's avatar fullpath.
     */
    public function getAvatarPath($avatarName): string
    {
        return $avatarName && file_exists(public_path("/img/avatars/{$avatarName}"))
            ? asset("img/avatars/{$avatarName}")
            : asset('img/avatars/profile-default.jpg');
    }


    /**
     * Define user's relations.
     */
    public function vacations() 
    {
        return $this->hasMany(Vacation::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
