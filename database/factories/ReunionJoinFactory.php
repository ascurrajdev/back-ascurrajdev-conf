<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reunion;
use App\Models\User;

class ReunionJoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "reunion_id" => Reunion::factory(),
            "user_id" => User::factory(),
            "joining_at" => now()
        ];
    }
}
