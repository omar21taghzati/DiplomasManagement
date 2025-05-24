<?php

namespace Database\Seeders;

use App\Models\Diploma;
use Database\Seeders\CertificatSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiplomaSeeder extends Seeder
{
    public static array $diplomas = [];

    public function run(): void
    {
        // Ensure CertificatSeeder has run
       // $this->call(CertificatSeeder::class);

        $undeliveredCertificatIds = CertificatSeeder::$undeliveredCertificatIdsDiploma;
        $deliveredCertificatIdsDiploma  = CertificatSeeder::$deliveredCertificatIdsDiploma ;

        foreach ($undeliveredCertificatIds as $id) {
            $createdDiploma = Diploma::factory()->create([
                'certificat_id' => $id,
            ]);

            self::$diplomas[] = $createdDiploma;
        }
        foreach ($deliveredCertificatIdsDiploma  as $id) {
            $createdDiploma = Diploma::factory()->create([
                'certificat_id' => $id,
            ]);

            self::$diplomas[] = $createdDiploma;
        }
    }
}

