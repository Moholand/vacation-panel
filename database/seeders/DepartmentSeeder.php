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

        foreach($departments as $department) {
            Department::create([
                'name' => $department,
            ]);
        }
    }
}
