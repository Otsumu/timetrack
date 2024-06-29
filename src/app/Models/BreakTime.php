<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    protected $table = 'breaktimes';

    protected $fillable = [
        'registereduser_id','attendance_id','break_start','break_end','date','break_time'
    ];

    public function attendance() {
        return $this->belongsTo(Attendance::class);
    }
}
