<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserDateSeeder;
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
        $this->call(UserDateSeeder::class);

    }
}
