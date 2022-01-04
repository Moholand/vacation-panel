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
            'department_id' => 2,
            'password' => Hash::make('mha123456789'),
        ]);

        User::create([
            'name' => 'مدیر کل',
            'email' => 'Admin@gmail.com',
            'password' => Hash::make('mha123456789'),
            'isVerified' => true,
            'isAdmin' => true,
        ]);

        \App\Models\User::factory(100)->create();
    }
}
