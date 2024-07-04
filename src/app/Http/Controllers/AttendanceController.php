<?php

namespace App\Http\Controllers;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index() {
        $now_date = Carbon::now()->format('Y-m-d');
        $user = Auth::user();

        if ($user->status === null) {
            $user->status = 0; 
            $user->save();
        }
        
        $status = $user->status ?? 0;
        $confirm_date = Attendance::where('registereduser_id', $user->id)
            ->where('date', $now_date)
            ->first();
        $attendances = Attendance::with(['breaktimes', 'registeredUser'])
            ->where('registereduser_id', $user->id)
            ->get();
  
        return view('index', compact('status', 'confirm_date','attendances'));
    }

    public function dateList(Request $request) {
        $user = Auth::user();

        $attendances = Attendance::with(['breaktimes','registeredUser'])
        ->where('registereduser_id', $user->id)
        ->paginate(5);

        return view('attendance.dateList',compact('attendances')); 
    }

    public function attendance(Request $request) {

        $now_date = now()->format('Y-m-d');
        $now_time = now()->format('H:i:s');
        $user = Auth::user();
        $end_of_day = '23:59:59';

        $attendance = Attendance::firstOrNew([
            'registereduser_id' => $user->id,
            'date' => $now_date
        ]);
        
        if($attendance && $attendance ->clock_in && $now_time > $end_of_day) {
            $attendance -> clock_out = $now_time;
            $attendance -> save();
            $user -> status = 1;
            $user -> save();
            $next_date = now()->addDay()->format('Y-m-d');
            $attendance = Attendance::firstOrNew([
                'registereduser_id' => $user ->id,
                'date' => $next_date
            ]);
        }

        if ($request->has('clock_in')) {
            $attendance->clock_in = $now_time;
            $attendance->save();
            $user->status = 1; 
        } elseif ($request->has('clock_out')) {
            $attendance->clock_out = $now_time;
            $attendance->save();
            $user->status = 3; 
        } elseif ($request->has('break_start')) {
            if($attendance && $attendance ->clock_in && $now_time > $end_of_day) {
                $attendance -> clock_out = $now_time;
                $attendance -> save();
                $user -> status = 2;
                $user -> save();
                $next_date = now()->addDay()->format('Y-m-d');
                $attendance = Attendance::firstOrNew([
                'registereduser_id' => $user->id,
                'date' => $next_date
            ]);
          }    
            $breaktime = new BreakTime();
            $breaktime->registereduser_id = $user->id;
            $breaktime->attendance_id = $attendance->id;
            $breaktime->date = $now_date;
            $breaktime->break_start = $now_time;
            $breaktime->save();
            $user->status = 2; 
        } elseif ($request->has('break_end')) {
            $breaktime = BreakTime::where('registereduser_id', $user->id)
                ->where('attendance_id', $attendance->id)
                ->where('date', $now_date)
                ->whereNull('break_end') 
                ->first();

            if ($breaktime) {
                $breaktime->break_end = $now_time;
                $breaktime->save();
                $user->status = 1; 
            }
        }
        $user->save();

        return redirect()->route('attendance_date');
    }

    public function show(Request $request) {
        $displayDate = Carbon::today(); 
        $attendances = Attendance::with(['registeredUser', 'breaktimes'])
            ->whereDate('date', $displayDate)
            ->paginate(5);
    
        return view('attendance.attendance_date', compact('displayDate', 'attendances'));
    }
    
    public function perDate(Request $request) {
        $displayDate = Carbon::parse($request->input('displayDate', Carbon::now()->toDateString()));

        if ($request->has('prevDate')) {
            $displayDate->subDay();  
        }

        if ($request->has('nextDate')) {
            $displayDate->addDay();
        }

        $attendances = Attendance::with(['registeredUser', 'breaktimes'])
            ->whereDate('date', $displayDate->toDateString())
            ->paginate(5);

        return view('attendance.attendance_date', compact('displayDate', 'attendances'));
    }

    public function user(Request $request) {
        $displayUser = $request->input('search__name');
        $userList = RegisteredUser::all();
        $attendances = collect(); 
        if ($displayUser) {
            $user = RegisteredUser::where('name', $displayUser)->first();
            
            if ($user) {
                $attendances = Attendance::where('user_id', $user->id)->paginate(10);
            }
        }
    
        return view('attendance.attendance_user', [
            'userList' => $userList,
            'searchparam' => $request->all(),
            'displayUser' => $displayUser,
            'attendances' => $attendances,
        ]);
    }
}