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

    \Log::info('User Status from Auth: ' . $user->status);

    $status = $user->status ?? 0;
    $confirm_date = Attendance::where('registereduser_id', $user->id)
        ->where('date', $now_date)
        ->first();

    \Log::info('Confirm Date: ' . print_r($confirm_date, true));

    $attendances = Attendance::where('registereduser_id', $user->id)
            ->with('breaktimes')
            ->get();

    \Log::info('User Status: ' . $status);

      return view('index', compact('status', 'attendances'));
  }


    public function dateList(){
    // dateList の処理を記述（例えば、必要なデータの取得やビューの表示など）
      return view('attendance.attendance_date'); // 適切なビュー名を指定してください
  }

  public function attendance(Request $request) {
    $now_date = now()->format('Y-m-d');
    $now_time = now()->format('H:i:s');
    $user = Auth::user();
    
    $attendance = Attendance::firstOrNew([
        'registereduser_id' => $user->id,
        'date' => $now_date
    ]);

    if ($request->has('clock_in')) {
        $attendance->clock_in = $now_time;
        $attendance->save();
        $user->status = 0; 
    } elseif ($request->has('clock_out')) {
        $attendance->clock_out = $now_time;
        $attendance->save();
        $user->status = 1; 
    } elseif ($request->has('break_start')) {
        $breaktime = new BreakTime();
        $breaktime->registereduser_id = $user->id;
        $breaktime->attendance_id = $attendance->id;
        $breaktime->date = $now_date;
        $breaktime->break_start = $now_time;
        $breaktime->save();
        $user->status = 1; 
    } elseif ($request->has('break_end')) {
        $breaktime = BreakTime::where('registereduser_id', $user->id)
                        ->where('attendance_id', $attendance->id)
                        ->where('date', $now_date)
                        ->first();

        if ($breaktime) {
            $breaktime->break_end = $now_time;
            $breaktime->save();
            $user->status = 2; 
        }
    }
      $user->save();

      return redirect()->route('attendance_date');
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
      $user = Auth::user();
      $attendances = Attendance::with('registeredUser')->where('registereduser_id',$user->id)->paginate(5);

      return view('attendance.attendance_date', compact('attendances'));
  }
}