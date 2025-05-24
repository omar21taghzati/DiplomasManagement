<?php

namespace Database\Seeders;

use App\Models\Secteur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static $secteurs=[];
    public function run(): void
    {
        
        for($i=1;$i<=3;$i++)
        {
            self::$secteurs[]=Secteur::factory()
                           ->create(
                            ['name'=>"secteur{$i}"],
                           );
        }
    }
}
