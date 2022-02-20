<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class VacationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Create from 1 to 10 vacations for each user
        User::where('isAdmin', false)->get()->each(function (User $user) {
            $vacations = \App\Models\Vacation::factory(random_int(1, 10))->make();

            $user->vacations()->saveMany($vacations);
        });

    }
}
