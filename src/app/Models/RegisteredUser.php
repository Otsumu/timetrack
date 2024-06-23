<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Model;

class RegisteredUser extends Authenticatable 
{
    use HasFactory;

    protected $table = 'registeredusers';

    protected $fillable = [
        'name', 'email', 'password','status',
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
