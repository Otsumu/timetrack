<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisteredUser extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'registeredusers';

    protected $fillable = [
        'name', 'email', 'password','status','email_verified_at', 
    ];
    
    protected $casts = [
        'status' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function attendances() {
        return $this->hasMany(Attendance::class,'registereduser_id');
    }

    public function breaktimes() {
        return $this->belongsToMany(BreakTime::class)->withPivot('break_time');
    }

    // Implement methods required by Authenticatable interface
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
