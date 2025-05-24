<?php

namespace Database\Seeders;

use App\Models\Group;
use Database\Seeders\FilierSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //  public static $groups=[];
    // public function run(): void
    // {
    //     $filiers = FilierSeeder::$filiers;

    //     foreach ($filiers as $filierGroup) { // $filierGroup is a collection of 2 Filiers
    //     foreach ($filierGroup as $filier) {
    //         self::$groups[] = Group::factory(2)
    //             ->create(['filier_id' => $filier->id]);
    //        }
    //    }
    // }

     public static array $groups = [];

    public function run(): void
    {
        $filiers = FilierSeeder::$filiers;

        foreach ($filiers as $filier) {
            $createdGroups = [];
              for ($i = 1; $i <=2; $i++) {
               $createdGroups[] = Group::factory()->create([
                'filier_id' => $filier->id,
                'name'=>"filier{$filier->id}_group{$i}",
            ]);
            }
            self::$groups = array_merge(self::$groups, $createdGroups);
        }
    }
}
