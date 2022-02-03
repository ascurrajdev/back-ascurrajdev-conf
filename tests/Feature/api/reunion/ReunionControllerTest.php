<?php

namespace Tests\Feature\api\reunion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Reunion;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReunionControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_reuniones_for_a_user()
    {
        $user = User::factory()
        ->hasReuniones(2)
        ->create();
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->getJson('/api/reuniones');
        $response->assertJsonStructure([
            "data" => [
                "*" => [
                    "id",
                    "created_at"
                ]
            ]
        ]);
        $response->assertJsonCount(2,"data");
        $response->assertOk();
    }

    /**
     * @test
     */
    public function should_list_when_user_not_contains_reuniones(){
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->getJson('/api/reuniones');
        $response->assertJsonCount(0,"data");
        $response->assertOk();
    }

    /**
     * @test
     */
    public function shouldnt_list_all_reuniones_a_user_not_authenticated(){
        $response = $this->getJson('/api/reuniones');
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_generate_a_reunion_a_user_autenticated(){
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->getJson("/api/reuniones/generate");
        $this->assertDatabaseCount("reuniones",1);
        $response->assertJsonStructure([
            "data" => [
                "id","created_at"
            ]
        ]);
        $response->assertCreated();
    }

    /**
     * @test
     */
    public function not_should_generate_a_reunion_user_not_authenticated(){
        $response = $this->getJson("/api/reuniones/generate");
        $this->assertDatabaseCount("reuniones",0);
        $response->assertUnauthorized();
    }
}
