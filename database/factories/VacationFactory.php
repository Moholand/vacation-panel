<?php

namespace Database\Factories;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Calculate Local date
        Verta::setStringformat('H:i Y-n-j');
        
        return [
            'title' => $this->faker->realText(30),
            'request_message' => $this->faker->realText(200),
            'response_message' => $this->faker->realText(100),
            'status' => $this->faker
                ->randomElement(['initial-approval', 'confirmed', 'refuse', 'submitted']),
            'type' => $this->faker->randomElement(['emergency', 'deserved']),
            'mode' => $this->faker->randomElement(['hourly', 'daily']),
            'from_date' => new Verta(now()),
            'to_date' => new Verta(now()->addDay(2)),
            'from_hour' => now()->format('H:m'),
            'to_hour' => now()->addHour(3)->format('H:m'),
        ];
    }
}
