<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_many_vacations()
    {
        $user = User::factory()->create(['isVerified' => 1]);

        $this->assertInstanceOf(Collection::class, $user->vacations);
    }

    /** @test */
    public function a_user_belongs_to_one_department()
    {
        $department = Department::factory()->create(); 
        $user = User::factory()->create(['department_id' => $department->id]);

        $this->assertInstanceOf(Department::class, $user->department);
    }
}
