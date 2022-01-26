<?php

namespace Tests\Feature\auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function error_validation_email_not_have_value_correct()
    {
        $response = $this->post('/register',[
            "email" => "test",
            "name" => "test",
            "password" => "12345678",
            "password_confirmation" => "12345678",
        ]);
        $response->assertInvalid("email");
    }

    /**
     * @test
     */
    public function error_validation_password_not_have_min_8_characters()
    {
        $response = $this->post('/register',[
            "email" => "test",
            "name" => "test",
            "password" => "1234567",
            "password_confirmation" => "1234567",
        ]);
        $response->assertInvalid("password");
    }

    /**
     * @test
     */
    public function error_validation_password_not_have_confirmation()
    {
        $response = $this->post('/register',[
            "email" => "test",
            "name" => "test",
            "password" => "12345678",
        ]);
        $response->assertInvalid("password");
    }

    /**
     * @test
     */
    public function error_validation_user_could_not_created_when_user_exists_with_same_email()
    {
        $user = User::factory()->create();
        $response = $this->post('/register',[
            "email" => "test",
            "name" => $user->email,
            "password" => "12345678",
            "password_confirmation" => "12345678",
        ]);
        $response->assertInvalid("email");
    }

    /**
     * @test
     */
    public function should_register_user_not_exists()
    {
        $response = $this->post('/register',[
            "email" => "test@example.com",
            "name" => "test",
            "password" => "12345678",
            "password_confirmation" => "12345678",
        ]);
        $response->assertNoContent();
        $this->assertDatabaseCount("users",1);
        $this->assertDatabaseHas("users",[
            "email" => "test@example.com",
        ]);
    }
}
