<?php

namespace Database\Factories;

use App\Models\RegisteredUser; 
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon; 

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    
    public function definition() {
      $dummyDate = $this->faker->dateTimeThisMonth;

      $clockIn = Carbon::createFromTimeString($dummyDate->format('H:i:s'));
      $clockOut = $clockIn->copy()->addHours(9);
      
      $interval = $clockIn->diff($clockOut);
      $workTime = $interval->format('%H:%I:%S');

      return [
        'registereduser_id' => function() {
            return RegisteredUser::factory()->create()->id;
        },

        'clock_in' => $clockIn->format('H:i:s'), 
        'clock_out' => $clockOut->format('H:i:s'), 
        'work_time' => $workTime,
        'date' => $dummyDate->format('Y-m-d'),  
        ];
    }
}
