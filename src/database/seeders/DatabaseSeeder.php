<?php

namespace Database\Seeders;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

    $users = RegisteredUser::factory(10)->create();
    foreach ($users as $user) {
        $attendance = Attendance::factory()->create(['registereduser_id' => $user->id]);

        BreakTime::factory()->create([
            'attendance_id' => $attendance->id,
            'registereduser_id' => $user->id,
            'break_start' => '19:49:26',
            'break_end' => '20:49:26',
            'date' => Carbon::now()->format('Y-m-d'),
        ]);
    }
  }
}

