<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use App\Models\RegisteredUser; 
use App\Models\Attendance;
use App\Models\BreakTime;  

class UserDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
  {
    $registeredUser = RegisteredUser::create([
       'name' => 'テスト太郎',
    ]);

    $attendance = Attendance::create([
       'registereduser_id' => $registeredUser->id,
       'clock_in' => '2024-06-09 09:00:00',
       'clock_out' => '2024-06-09 17:00:00',
    ]);

    BreakTime::create([
       'registereduser_id' => $registeredUser->id,
       'attendance_id' => $attendance->id,
       'break_time' => '01:00:00',
    ]);
  }
}