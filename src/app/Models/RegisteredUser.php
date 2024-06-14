<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredUser extends Model
{
    use HasFactory;

    protected $table = 'registeredusers';

    protected $fillable = [
        'name','email','password',
    ];

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

    public function breaktimes() {
        return $this->belongsToMany(BreakTime::class)->withPivot('break_time');
    }
}
