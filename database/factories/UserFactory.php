<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'about' => $this->faker->sentence(),
            'email' => $this->faker->unique()->safeEmail(),
            'date_naissance'=>$this->faker->dateTimeBetween('-60 years','-18 years')->format('Y-m-d'),
            // 'email_verified_at' => now(), // Décommentez si vous avez cette colonne et souhaitez la remplir
            'password' => static::$password ??= Hash::make('123456'), // Définit un mot de passe par défaut "password"
            'role' => fake()->randomElement(['directeur','gestionnaire','stagiaire']), // Par défaut, crée des clients
            'phone' => $this->faker->phoneNumber(), // Rend le téléphone optionnel (peut être null)
            // 'city' => $this->faker->optional()->city(),      // Rend la ville optionnelle
            'photo' =>  null, // Vous pouvez mettre une URL d'image placeholder si vous voulez
            // 'bio' => $this->faker->optional()->paragraph(2), // Rend la bio optionnelle
            // 'remember_token' => Str::random(10), // Décommentez si vous utilisez remember_token
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
