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
        return [
            'title' => $this->faker->realText(30),
            'request_message' => $this->faker->realText(200),
            'status' => $status = $this->faker
                ->randomElement(['initial-approval', 'confirmed', 'refuse', 'submitted']),
            'response_message' => $status === 'confirmed' ? $this->faker->realText(100) : '',
            'type' => $this->faker->randomElement(['emergency', 'deserved']),
            'mode' => $mode = $this->faker->randomElement(['hourly', 'daily']),
            'from_date' => new Verta(now()),
            'to_date' => $mode === 'daily' ? new Verta(now()->addDay(2)) : null,
            'from_hour' => $mode === 'hourly' ? now()->format('H:m') : null,
            'to_hour' => $mode === 'hourly' ? now()->addHour(3)->format('H:m') : null,
        ];
    }
}
