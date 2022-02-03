<?php

namespace Tests\Feature\api\reunion;

use App\Models\Reunion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\ReunionJoin;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReunionesJoinControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_reuniones_join_user()
    {
        $user = User::factory()->hasReuniones(2)->create();
        ReunionJoin::factory()->create([
            "reunion_id" => $user->reuniones->first()->id,
            "user_id" => $user->id
        ]);
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->getJson('/api/reuniones/unirse');
        $response->assertJsonCount(1,"data");
        $response->assertJsonStructure([
            "data" => [
                "*" => [
                    "reunion_id",
                    "joining_at",
                    "disconnected_at"
                ]
            ]
        ]);
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_list_reunion_when_user_not_authenticated(){
        $response = $this->getJson("/api/reuniones/unirse");
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_join_a_reunion_with_a_user(){
        $user = User::factory()->hasReuniones(1)->create();
        $reunion = Reunion::first();
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->postJson("/api/reuniones/unirse",[
            "reunion_id" => $reunion->id
        ]);
        $this->assertDatabaseCount("reuniones_join",1);
        $response->assertJsonStructure([
            "user_id",
            "reunion_id",
            "joining_at",
        ]);
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_disconnect_of_reunion_with_a_user(){
        $user = User::factory()->create();
        $reunion = Reunion::factory()->create([
            "user_id" => $user->id
        ]);
        ReunionJoin::factory()->create([
            "user_id" => $user->id,
            "reunion_id" => $reunion->id,
        ]);
        Sanctum::actingAs(
            $user,
            ["*"]
        );
        $response = $this->postJson("/api/reuniones/desconectarse",[
            "reunion_id" => $reunion->id,
        ]);
        $response->assertJsonStructure([
            "user_id",
            "reunion_id",
            "joining_at",
            "disconnected_at"
        ]);
        $response->assertSuccessful();
    }

}
