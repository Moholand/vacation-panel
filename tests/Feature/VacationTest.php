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

        $user = User::factory()->create();

        $this->actingAs($user);

        $attribute = [
            'title' => 'سلام',
            'request_message' => 'سلام بر تو',
            'user_id' => $user->id,
            'from_date' => '1400-12-24',
            'to_date' => '1400-14-24'
        ];

        $this->post('/vacations', $attribute);

        $this->assertDatabaseHas('vacations', $attribute);
    }
}
