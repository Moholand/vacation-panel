<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_create_vacation()
    {
        $user = User::factory()->create(['isVerified' => 1]);

        $this->actingAs($user);

        $attribute = [
            'title' => 'سلام',
            'request_message' => 'سلام بر تو',
            'type' => 'deserved',
            'mode' => 'daily',
            'user_id' => $user->id,
            'status' => 'submitted',
            'from_date' => '1400-12-24',
            'to_date' => '1401-12-24'
        ];

        $this->post('/vacations', $attribute)->assertRedirect(route('vacations.index'));

        $this->assertDatabaseHas('vacations', $attribute);
    }

    /** @test */
    public function unverified_users_may_not_create_vacation()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $attribute = Vacation::factory()->raw(['user_id' => $user->id]);

        $this->post('/vacations', $attribute);

        $this->assertDatabaseCount('vacations', 0);
    }

    /** @test */
    public function a_vacation_requires_a_title()
    {
        $attribute = Vacation::factory()->raw(['title' => '']);

        $user = User::factory()->create(['isVerified' => 1]);

        $this->actingAs($user);

        $this->post('/vacations', $attribute)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_vacation_requires_a_request_message()
    {
        $attribute = Vacation::factory()->raw(['request_message' => '']);

        $user = User::factory()->create(['isVerified' => 1]);

        $this->actingAs($user);

        $this->post('/vacations', $attribute)->assertSessionHasErrors('request_message');
    }

    /** @test */
    public function only_authenticated_users_can_create_vacation()
    {
        $attribute = Vacation::factory()->raw();

        $this->post('/vacations', $attribute)->assertRedirect('login');
    }
}
