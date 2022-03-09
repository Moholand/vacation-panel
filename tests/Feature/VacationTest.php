<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_create_vacation()
    {
        $this->withoutExceptionHandling();

        $user = User::withoutEvents(function() {
            return User::factory()->create([
                'isVerified' => 1
            ]);
        });

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

        $this->post('/vacations', $attribute);

        $this->assertDatabaseHas('vacations', $attribute);
    }
}
