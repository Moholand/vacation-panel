<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'واحد فرانت اند', 'واحد بک اند', 'واحد طراحی', 'منابع انسانی', 'واحد خدمات'
        ];

        foreach($departments as $department) {
            Department::create([
                'name' => $department
            ]);
        }
    }
}
