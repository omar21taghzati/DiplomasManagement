<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BacSeeder;
use Database\Seeders\CertificatSeeder;
use Database\Seeders\DiplomaSeeder;
use Database\Seeders\DirecteurSeeder;
use Database\Seeders\FilierSeeder;
use Database\Seeders\GestionnaireSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\SecteurSeeder;
use Database\Seeders\StagiaireSeeder;
use Database\Seeders\StatisticSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
     // Call other seeders here
        $this->call([
            UserSeeder::class,
            DirecteurSeeder::class,
            GestionnaireSeeder::class,
            CertificatSeeder::class,
            BacSeeder::class,
            DiplomaSeeder::class,
            SecteurSeeder::class,
            FilierSeeder::class,
             GroupSeeder::class,
            StagiaireSeeder::class,
            StatisticSeeder::class,
            // Add any other seeders you want to run here
        ]);
    }
}
