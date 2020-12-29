<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUuid, CausesActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'device_name',
        'device_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deviceTokens()
    {
        return $this->hasMany(UserDeviceToken::class);
    }

    public static function getAdmins()
    {
        return collect(config('admins.admins'));
    }

    public static function isAdmin($email)
    {
        return self::getAdmins()->contains($email);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }
}
