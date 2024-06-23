<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RegisteredUser;
use App\Models\Attendance;
use App\Models\BreakTime;

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
    
        $breakStart = $dummyDate->format('Y-m-d 08:00:00');
        $breakEnd = $dummyDate->modify('+1 hour')->format('Y-m-d 09:00:00');
    
        return [
            'break_start' => $breakStart,
            'break_end' => $breakEnd,
            'attendance_id' => function() {
                return Attendance::factory()->create()->id;
            },
            'registereduser_id' => function() {
                return RegisteredUser::factory()->create()->id;
            },
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
