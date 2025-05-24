<?php

namespace Database\Seeders;

use App\Models\Bac;
use Database\Seeders\CertificatSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static $bacs=[];
    public function run(): void
    {
        // Ensure CertificatSeeder has run before accessing the IDs
        //$this->call(CertificatSeeder::class);

        // Get the delivered certificates from CertificatSeeder
        $deliveredCertificatIdsBac = CertificatSeeder::$deliveredCertificatIdsBac;
        $undeliveredCertificatIdsBac = CertificatSeeder::$undeliveredCertificatIdsBac;
        $reservedCertificatesIds = CertificatSeeder::$reservedCertificatesIds;

        // Use the delivered certificates to create Bac records
        foreach( $deliveredCertificatIdsBac as $id)
        {
           $createdbacs=Bac::factory()->create([
            'certificat_id' => $id, // Randomly assign an undelivered Certificat ID
        ]);

          self::$bacs []=  $createdbacs;
        }
        foreach(  $undeliveredCertificatIdsBac as $id)
        {
           $createdbacs=Bac::factory()->create([
            'certificat_id' => $id, // Randomly assign an undelivered Certificat ID
        ]);

          self::$bacs []=  $createdbacs;
        }

        foreach( $reservedCertificatesIds as $id)
        {
           $createdbacs=Bac::factory()->create([
            'certificat_id' => $id, // Randomly assign an undelivered Certificat ID
        ]);

          self::$bacs []=  $createdbacs;
        }
    }
}
