<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $connection = 'mysql';
 
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    public function getIsAdminAttribute()
    {
        return $this->roles->pluck( 'name' )->contains( 'admin' );
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->roles->pluck( 'name' )->contains( 'superadmin' );
    }
    public function getIsUserAttribute()
    {
        return $this->roles->pluck( 'name' )->contains( 'user' );
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

 
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFirstNameAttribute(){
        return Str::of($this->name)->explode(' ')[0];
    }
}
