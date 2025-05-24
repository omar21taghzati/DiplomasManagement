<?php

namespace Database\Seeders;

use App\Models\Stagiaire;
use App\Models\Statistic;
use Database\Seeders\CertificatSeeder;
use Database\Seeders\DirecteurSeeder;
use Database\Seeders\GestionnaireSeeder;
use Database\Seeders\StagiaireSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     // $usersList = UserSeeder::$users;
         
    //      $stagiairesList=StagiaireSeeder::$stagiaires;
    //      $gestionnairesList=GestionnaireSeeder::$gestionnaires;
    //      $directeursList=DirecteurSeeder::$directeurs;
    //     if(count($stagiairesList)>0 && (count( $gestionnairesList)>0 || count($directeursList)>0)){
    //        $managerId=count( $gestionnairesList)>0 ?$gestionnairesList[0]->id:$directeursList[0]->id;
           
    //         foreach ($stagiairesList as $stagiaire) {
          
    //              Statistic::factory()->create([
    //             'user_id' =>$managerId,
    //             'stagiaire_id'=>$stagiaire->id,
    //              'certificat_id' =>$stagiaire->bac_id,
    //              'type_cerf'=>'bac',
    //             // other directeur-specific fields
    //            ]);

    //            Statistic::factory()->create([
    //             'user_id' =>$managerId,
    //             'stagiaire_id'=>$stagiaire->id,
    //             'certificat_id' =>$stagiaire->diploma_id,
    //             'type_cerf'=>'diploma',
    //             // other directeur-specific fields
    //            ]);
        
    //     }
    //     }
    // }

    public function run(): void
{
    $stagiairesList = StagiaireSeeder::$stagiaires;
    $gestionnairesList = GestionnaireSeeder::$gestionnaires;
    $directeursList = DirecteurSeeder::$directeurs;

    if (count($stagiairesList) > 0 && (count($gestionnairesList) > 0 || count($directeursList) > 0)) {
        $managerId = count($gestionnairesList) > 0 
            ? $gestionnairesList[0]->id 
            : $directeursList[0]->id;

        foreach ($stagiairesList as $stagiaire) {
            if ($stagiaire->bac_id) {
                 if($stagiaire->bac->certificat->status=='delivered')
                {
                     Statistic::factory()->create([
                    'user_id' => $managerId,
                    'stagiaire_id' => $stagiaire->id,
                    'certificat_id' =>  $stagiaire->bac->certificat->id,
                    'type_cerf' => 'bac',
                    'taking_duration'=>null,
                    'return_date'=>null,
                ]);
                }
                else if($stagiaire->bac->certificat->status=='reserved')
                {
                     Statistic::factory()->create([
                    'user_id' => $managerId,
                    'stagiaire_id' => $stagiaire->id,
                    'certificat_id' => $stagiaire->bac->certificat->id,
                    'type_cerf' => 'bac',
                    'return_date'=>null,
   
                ]);
                }

                else{
                      Statistic::factory()->create([
                    'user_id' => null,
                    'stagiaire_id' => $stagiaire->id,
                    'certificat_id' =>  $stagiaire->bac->certificat->id,
                    'type_cerf' => 'bac',
                    'taking_duration'=>null,
                    'return_date'=>null,
                    'taken_date'=>null,
                    'additional_notes'=>null,
                     ]);
                }
               
            }

            if ($stagiaire->diploma_id) {
                if($stagiaire->diploma->certificat->status=='delivered')
                {
                     Statistic::factory()->create([
                    'user_id' => $managerId,
                    'stagiaire_id' => $stagiaire->id,
                    'certificat_id' =>  $stagiaire->diploma->certificat->id,
                    'type_cerf' => 'diploma',
                    'taking_duration'=>null,
                    'return_date'=>null,
                ]);
                }
                else{
                     Statistic::factory()->create([
                    'user_id' => null,
                    'stagiaire_id' => $stagiaire->id,
                    'certificat_id' =>$stagiaire->diploma->certificat->id,
                    'type_cerf' => 'diploma',
                    'taking_duration'=>null,
                    'return_date'=>null,
                    'taken_date'=>null,
                    'additional_notes'=>null,
                ]);
                }
               
            }
        }
    }
}

}
