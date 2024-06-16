<?php

namespace Database\Seeders;

use App\Models\RegisteredUser;
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
        RegisteredUser::factory(35)->create();

    }
}
