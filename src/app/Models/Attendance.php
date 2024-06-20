<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'registereduser_id','clock_in','clock_out','work_time','date',
    ];

    public function user(){
        return $this->belongsTo(RegisteredUser::class, 'registereduser_id');
    }

    public function breaktimes () {
        return $this->hasMany(BreakTime::class);
    }
}
