<?php

namespace Database\Seeders;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *php artisan migrate:fresh --seed

     * @return void
     */
    public function run(){

    $faker = Faker::create();

    $users = RegisteredUser::factory(10)->create();
    foreach ($users as $user) {
        $attendance = Attendance::factory()->create(['registereduser_id' => $user->id]);

        $dummyDate = Carbon::instance($faker->dateTimeThisMonth);
        $breakStart = $dummyDate->format('H:i:s');
        $breakEnd = $dummyDate->copy()->addHour()->format('H:i:s');

        BreakTime::factory()->create([
            'attendance_id' => $attendance->id,
            'registereduser_id' => $user->id,
            'break_start' => $breakStart,
            'break_end' => $breakEnd,
            'date' => $dummyDate->format('Y-m-d'),
        ]);
    }
  }
}

