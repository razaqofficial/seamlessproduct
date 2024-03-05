<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
#use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login()
    {
        // Create a factory user
        $user = User::factory()->create();

        $loginResponse = $this->postJson('/api/auth/login',
            ['email' => $user->email, 'password' => 'password']);

        $loginResponse->assertStatus(200)
        ->assertJsonStructure([
            'user', 'token', 'success'
        ]);

        // Get the token and validate it by using it to retrieve the user details
        $token = $loginResponse->getData()->token;

        $profileResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/profile');

        $profileResponse->assertOk()->assertJsonStructure([
            'user', 'success', 'message'
        ]);

        //Assert user loged in user object and user object received from the profile response are the same
        $this->assertSame($user->id, $profileResponse->getData()->user->id);


        // Invalid login credentials
        $invalidLoginResponse = $this->postJson('/api/auth/login',
            ['email' => 'faker@test.com', 'password' => 'password234']);

        $invalidLoginResponse->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials',
                'success' => false
            ]);

    }

    public function test_user_profile_can_be_retrieved()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->get('/api/profile');

        $response->assertOk();

        $response->assertJsonStructure([
            'user', 'success', 'message'
        ]);
    }
}
