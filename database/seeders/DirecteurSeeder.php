<?php

namespace Database\Seeders;

use App\Models\Directeur;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static $directeurs=[];
    public function run(): void
    {
        //$this->call(UserSeeder::class);
        $DirecteurList = UserSeeder::$userDirecteurs;
        if(count($DirecteurList)>0){
             foreach ($DirecteurList as $user) {
                self::$directeurs[]= Directeur::factory()->create([
                'user_id' => $user->id,
                // other directeur-specific fields
               ]);
            }
        }
       
    }
}
