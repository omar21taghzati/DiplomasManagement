<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static  $users=[];
    public static  $userDirecteurs=[];
    public static  $userGestionnaire=[];
    public function run(): void
    {
       
        for($j=1;$j<=5;$j++)
        {
              $seed = Str::random(15);
              $avatarUrl = "https://api.dicebear.com/7.x/personas/svg?seed={$seed}";
      
              if ($j==1 || $j==3)
              {
                     self::$userDirecteurs[]=User::factory()->create([
                   'password' => Hash::make('123456789'),
                   'role' => 'directeur',
                   'photo'=>"https://api.dicebear.com/7.x/personas/svg?seed={$seed}",
                     ]);
              }
              else{
                     self::$userGestionnaire[]=User::factory()->create([
                    'password' => Hash::make('123456789'),
                    'role' => 'gestionnaire',
                    'photo'=>"https://api.dicebear.com/7.x/personas/svg?seed={$seed}",
                    ]);
            }
        }

         for ($i = 1; $i <=92; $i++) {
            $seed = Str::random(15);
            $avatarUrl = "https://api.dicebear.com/7.x/personas/svg?seed={$seed}";

            self::$users[] = User::factory()->create([
                'photo' => $avatarUrl,
                'password' => Hash::make('123456789'),
                'role'=>'stagiaire',
            ]);
           
        }

    }

   
}
