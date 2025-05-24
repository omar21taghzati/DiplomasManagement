<?php

namespace Database\Factories;

use App\Models\Bac;
use App\Models\Diploma;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stagiaire>
 */
class StagiaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'CEF' => $this->faker->unique()->bothify('CEF####'), // e.g., CEF1234
            'obtainBacDate' => $this->faker->date(),
            'obtainDiplomaDate' => $this->faker->date(),

            // Make sure related models exist or you seed them beforehand
            'bac_id' => Bac::factory(),
            'diploma_id' => Diploma::factory(),
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
        ];
    }
}