<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'محمد حسین اکبرزاده',
            'email' => 'mohammad@gmail.com',
            'position' => 'توسعه‌دهنده بک‌اند',
            'password' => Hash::make('mha123456789'),
        ]);

        User::create([
            'name' => 'علی نبی‌زاده',
            'email' => 'ali@gmail.com',
            'position' => 'توسعه‌دهنده فرانت‌اند',
            'password' => Hash::make('mha123456789'),
        ]);

        User::create([
            'name' => 'دانیال اسماعیلی',
            'email' => 'danial@gmail.com',
            'position' => 'طراح',
            'password' => Hash::make('mha123456789'),
        ]);

        User::create([
            'name' => 'مدیر کل',
            'email' => 'Admin@gmail.com',
            'position' => 'مدیر‌عامل',
            'password' => Hash::make('mha123456789'),
            'isVerified' => true,
            'isAdmin' => true,
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
