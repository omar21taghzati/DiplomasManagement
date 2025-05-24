<?php

namespace Database\Seeders;

use App\Models\Gestionnaire;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public static $gestionnaires=[];
    public function run(): void
    {
      //  $this->call(UserSeeder::class);
        $GestionnaireList = UserSeeder::$userGestionnaire;
         if(count($GestionnaireList)>0)
         {
             foreach ($GestionnaireList as $user) {
           
                self::$gestionnaires[]=Gestionnaire::factory()->create([
                'user_id' => $user->id,
                
                // other directeur-specific fields
               ]);

           
        }
         }
       
    }
}
