<?php

namespace Database\Seeders;

use App\Models\Filier;
use Database\Seeders\SecteurSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public static $filiers=[];
    // public function run(): void
    // {
    //     $secteurs=SecteurSeeder::$secteurs;
    //     //$filiers=Filier::factory()
    //     foreach($secteurs as $secteur)
    //     {
    //         self::$filiers[]=Filier::factory(2)
    //         ->create(['secteur_id'=>$secteur->id]);
    //     }
    // }


    public static $filiers = [];

    public function run(): void
    {
        $secteurs = SecteurSeeder::$secteurs;
        //  $createdFiliers = Filier::factory(2)->create([
        //         'secteur_id' => $secteur->id
        //     ]);
        $j=0;
        foreach ($secteurs as $secteur) {
            $createdFiliers = [];
            for ($i = 1; $i <=2; $i++) {
                $j++;
                $createdFiliers[] = Filier::factory()->create([
                'secteur_id' => $secteur->id,
                'name'=>"secteur{$secteur->id}_filier{$j}",
                ]);
            }
            self::$filiers = array_merge(self::$filiers, $createdFiliers);
        }
    }
}
