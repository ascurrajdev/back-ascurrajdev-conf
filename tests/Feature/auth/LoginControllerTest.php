<?php

namespace Tests\Feature\auth;

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
    public function should_login_a_user_exists_with_corrects_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('/login',[
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertNoContent();
    }

    /**
     * @test
     */
    public function not_should_login_a_user_exists_with_incorrects_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('/login',[
            "email" => $user->email,
            "password" => "password1"
        ]);
        $response->assertInvalid("email");
    }
    
    /**
     * @test
     */
    public function not_should_login_a_user_not_exists()
    {
        $response = $this->post('/login',[
            "email" => "email@example.com",
            "password" => "password1"
        ]);
        $response->assertInvalid("email");
    }
}
