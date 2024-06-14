<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index() {
        return view('index');
    }

    public function showAttendance() {
        $attendancesByDate = [
            'attendance_date' => [
                [   
                    'date' => '2024-06-05',
                    'attendances' => [
                        (object) [
                            'name' => 'John',
                            'clock_in' => '09:00:00',
                            'clock_end' => '18:00:00',
                            'break_start' => '12:00:00',
                            'work_hours' => '08:00:00',
                        ],
                        (object) [
                            'name' => 'Alice',
                            'clock_in' => '08:30:00',
                            'clock_end' => '17:30:00',
                            'break_start' => '12:30:00',
                            'work_hours' => '07:30:00',
                        ],
                        (object) [
                            'name' => 'Bob',
                            'clock_in' => '09:15:00',
                            'clock_end' => '18:15:00',
                            'break_start' => '12:15:00',
                            'work_hours' => '08:00:00',
                        ],
                        (object) [
                            'name' => 'Emily',
                            'clock_in' => '08:45:00',
                            'clock_end' => '17:45:00',
                            'break_start' => '12:45:00',
                            'work_hours' => '07:45:00',
                        ],
                        (object) [
                            'name' => 'Mike',
                            'clock_in' => '07:45:00',
                            'clock_end' => '16:45:00',
                            'break_start' => '11:45:00',
                            'work_hours' => '07:45:00',
                        ],
                    ],
                ],
            ],
        ];
        
        return view('attendance', compact('attendancesByDate'));
    }
}    