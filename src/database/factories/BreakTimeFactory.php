<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummyDate = $this->faker->dateTimeThisMonth;
    
        $breakStart = $dummyDate->format('H:i:s');
        $breakEnd = (clone $dummyDate)->modify('+1 hour')->format('H:i:s');
    
        return [
            'break_start' => $breakStart,
            'break_end' => $breakEnd,
            'attendance_id' => function() {
                return Attendance::factory()->create()->id;
            },
            'registereduser_id' => function() {
                return RegisteredUser::factory()->create()->id;
            },
            'date' => Carbon::now()->format('Y-m-d'), 
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}