<?php

namespace App\Http\Controllers;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index() {
      $user = Auth::user();
      $status = $user->status;
      return view('index',compact('status'));
    }

    public function dateList(){
    $dates = Attendance::selectRaw('DATE(created_at) as date')
        ->groupByRaw('DATE(created_at)')
        ->orderByRaw('DATE(created_at) DESC')
        ->get();

      return view('attendance.attendance_date', compact('dates'));
    }

    public function show(Request $request) {
      $date = $request->input('date');
      $attendances = Attendance::whereDate('created_at', $date)->get();

      return view('attendance.attendance_user', compact('date','attendances'));
    }

    public function store(Request $request) {
      $now_date = now()->format('Y-m-d');
      $now_time = now()->format('H:i:s');
      $user_id = Auth::user()->id;
        
      $existingAttendance = Attendance::where('date', $now_date)
        ->where('registereduser_id', $user_id)
        ->first();
      if ($existingAttendance) {
        return redirect()->back()->with('error', '本日の出勤はすでに記録されています。');
      } 
        else {
          $now_datetime = Carbon::now()->format('Y-m-d H:i:s');
          $attendance = new Attendance();
          $attendance->date = $now_date;
          $attendance->clock_in = $now_datetime;
          $attendance->registereduser_id = $user_id;
          $attendance->save();
            
        return redirect()->back()->with('success', '出勤を記録しました。');
      }
    }
}
