<?php

namespace App\Http\Controllers;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index() {
      $now_date = Carbon::now()->format('Y-m-d');
      $user = Auth::user();
      $status = $user->status;
      $confirm_date = Attendance::where('registereduser_id', $user->id)
        ->where('date', $now_date)
        ->first();

      if(!$confirm_date) {
        $status = 0; 
      } 
      return view('index',compact('status'));
    }

    public function attendance(Request $request) {
      $now_date = Carbon::now()->format('Y-m-d');
      $now_datetime = Carbon::now();
      $user = Auth::user();
      $user_id = Auth::user()->id;
        if($request->has('clock_in') || $request->has('clock_end')) {
          $attendance = Attendance::where('registereduser_id',$user->id)
          ->where('date', $now_date)
          ->first();
        }  
          if (!$attendance) {
            $attendance = new Attendance();
            $attendance->registereduser_id = $user->id;
            $attendance->date = $now_date;
        }

          if($request->has('clock_in')) {
            $attendance->clock_in = $now_datetime; 
            $attendance->save();
            $status = 1;
            return redirect()->route('attendance_date')->with('success', '勤務開始します、本日もよろしくお願いします！');
          }

          if($request->has('break_start')) {
            $attendance->break_start = $now_datetime; 
            $attendance->save();
            $status = 2;
            return redirect()->route('attendance_date')->with('success', '休憩開始します！');
          }

          if($request->has('break_end')) {
            $attendance->break_end = $now_datetime; 
            $attendance->save();
            $status = 1;
            return redirect()->route('attendance_date')->with('success', '休憩終了します！');
          }

          if($request->has('clock_out')) {
            $attendance->clock_out  = $now_datetime;
            $attendance->save();
            $status = 3;
            return redirect()->route('attendance_date')->with('success', '勤務終了です、本日もお疲れ様でした！');
          }
      }  
    
    public function attendanceDate() {
      $registeredUsers = RegisteredUser::paginate(5);  
      return view('attendance.attendance_date', compact('registeredUsers'));
      }
      
}  