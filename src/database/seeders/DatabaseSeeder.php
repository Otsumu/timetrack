<?php

namespace Database\Seeders;

use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AttendancesTableSeeder::class);

    }
}
