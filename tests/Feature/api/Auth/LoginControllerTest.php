<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_login_with_a_user_exists()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.login'),[
            "email" => $user->email,
            "password" => "password", // default password in factory,
            "platform" => "Windows"
        ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                "token",
                "type"
            ]
        ]);
    }

    /**
     * @test
     */
    public function cannot_login_with_credentials_incorrects(){
        $user = User::factory()->create();
        $response = $this->postJson(route('api.login'),[
            "email" => $user->email,
            "password" => "pass", // default password in factory,
            "platform" => "Windows"
        ]);
        $response->assertStatus(422);
    }
}
