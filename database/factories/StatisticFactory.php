<?php

namespace Database\Factories;

use App\Models\Certificat;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistic>
 */
class StatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
      // {
      //     // Ensure logic: return_date >= taken_date
      //     $takenDate = $this->faker->date();//return string like "2023-06-10"
      //     $duration = $this->faker->numberBetween(1, 15); // duration in days, return integer like 10
      //     $returnDate = date('Y-m-d', strtotime($takenDate . " +{$duration} days"));//return string like "2023-16-10"
  
      //     return [
      //         'additional_notes' => $this->faker->optional()->sentence(),
      //         'taken_date' => $takenDate,
      //         'return_date' => $returnDate,
      //         'taking_duration' => $duration,
      //         'type_cerf' => $this->faker->randomElement(['bac', 'diploma']),
  
      //         // Foreign keys assuming factories exist for these models
      //         'user_id' => User::factory(),
      //         'stagiaire_id' => Stagiaire::factory(),
      //         'certificat_id' => Certificat::factory(),
      //     ];
      // }
public function definition(): array
{
    // Set a taken_date between Jan 1, 2023 and today
    $takenDate = $this->faker->dateTimeBetween('2023-01-01', 'now')->format('Y-m-d');

    // Duration in days
    $duration = $this->faker->numberBetween(1, 15);

    // Ensure return_date is after taken_date
    $returnDate = date('Y-m-d', strtotime($takenDate . " +{$duration} days"));

    return [
        'additional_notes' => $this->faker->optional()->sentence(),
        'taken_date' => $takenDate,
        'return_date' => $returnDate,
        'taking_duration' => $duration,
        'type_cerf' => $this->faker->randomElement(['bac', 'diploma']),

        // Foreign keys assuming factories exist for these models
        'user_id' => User::factory(),
        'stagiaire_id' => Stagiaire::factory(),
        'certificat_id' => Certificat::factory(),
    ];
}


    }
