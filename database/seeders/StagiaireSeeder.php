<?php

namespace Database\Seeders;

use App\Models\Stagiaire;
use Database\Seeders\BacSeeder;
use Database\Seeders\DiplomaSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StagiaireSeeder extends Seeder
{
    public static $stagiaires = [];

    public function run(): void
    {
        $users = UserSeeder::$users;
        $groups = GroupSeeder::$groups;
        $bacs = BacSeeder::$bacs;
        $diplomas = DiplomaSeeder::$diplomas;

        $index = 0;
        $i = 0;

        foreach ($users as $user) {
            
                self::$stagiaires[] = Stagiaire::factory()->create([
                    'user_id' => $user->id,
                    'bac_id' => $bacs[$index],
                    'diploma_id' => $diplomas[$index],
                    'group_id' => $groups[$i],
                ]);

                $index++;

               if (count($groups) - 1 > $i) {
                        $i++;
                    } else {
                        $i = 0;
                    }

            
        }
    }
}

