<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
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
            'واحد مدیریت',
            'واحد فرانت اند',
            'واحد بک اند',
            'واحد طراحی',
            'منابع انسانی',
            'واحد خدمات'
        ];

        // First create 1 department
        // Then create administrator for that department and assign
        // At last create 20 users for that department
        foreach($departments as $department) {
            $department = Department::create([
                'name' => $department
            ]);

            $administrator = \App\Models\User::factory()->create([
                'department_id' => $department->id
            ]);

            $department->head_id = $administrator->id;
            $department->save();

            \App\Models\User::factory(20)->create([
                'department_id' => $department->id
            ]);
        }
    }
}
