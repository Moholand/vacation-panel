<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
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
}
