<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificat>
 */
class CertificatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'issuedDate' => $this->faker->date(),
            'status' => $this->faker->randomElement(['delivered', 'undelivered']),
            'image' => 'https://api.dicebear.com/7.x/identicon/svg?seed=' . Str::random(16),
            'notes' => $this->faker->optional()->sentence(),
        ];
        //  'image' => $this->faker->imageUrl()
    }
}