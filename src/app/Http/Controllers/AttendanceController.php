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

    public function dateList(){
    // dateList の処理を記述（例えば、必要なデータの取得やビューの表示など）
      return view('attendance.attendance_date'); // 適切なビュー名を指定してください
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
            return redirect()->route('attendance_date');
          }

          if($request->has('break_start')) {
            $attendance->break_start = $now_datetime; 
            $attendance->save();
            $status = 2;
            return redirect()->route('attendance_date');
          }

          if($request->has('break_end')) {
            $attendance->break_end = $now_datetime; 
            $attendance->save();
            $status = 1;
            return redirect()->route('attendance_date');
          }

          if($request->has('clock_out')) {
            $attendance->clock_out  = $now_datetime;
            $attendance->save();
            $status = 3;
            return redirect()->route('attendance_date');
          }
      }  
    
    public function show(Request $request) {
      $displayDate = Carbon::now();
      var_dump($displayDate);

      $users = DB::table('attendances')
          ->whereDate('date', $displayDate->toDateString())
          ->paginate(5);
      
      return view('attendance.attendance_date', compact('displayDate', 'users'));
  }
  
     public function perDate(Request $request) {
      $displayDate = Carbon::parse($request->input('displayDate', Carbon::now()->toDateString()));
      var_dump($displayDate);

      if ($request->has('prevDate')) {
          $displayDate->subDay();  
      }

      if ($request->has('nextDate')) {
          $displayDate->addDay();
      }

      $users = DB::table('attendances')
          ->whereDate('date', $displayDate->toDateString())
          ->paginate(5);

      return view('attendance.attendance_date', compact('displayDate', 'users'));
  }   

    public function attendanceDate() {
      $attendances = Attendance::with('registeredUser')->paginate(5); 
            return view('attendance.attendance_date', compact('attendances'));
  }
}