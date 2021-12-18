<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jobName = [
            'برنامه‌نویس فرانت‌اند',
            'برنامه‌نویس بک‌اند',
            'برنامه‌نویس فول‌استک',
            'برنامه‌نویس دواپس',
            'متخصص هوش مصنوعی',
            'مهندس داده',
            'متخصص ui/ux',
            'مسئول منابع انسانی',
        ];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'position' => $jobName[random_int(0, count($jobName) - 1)],
            // 'email_verified_at' => now(),
            'password' => Hash::make('mha123456789'),
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
