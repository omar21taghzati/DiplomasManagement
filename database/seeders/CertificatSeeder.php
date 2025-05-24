<?php

namespace Database\Seeders;

use App\Models\Certificat;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     // Store the IDs in static properties
    public static $undeliveredCertificatIdsBac = [];
    public static $undeliveredCertificatIdsDiploma = [];
    public static $deliveredCertificatIdsBac = [];
    public static $deliveredCertificatIdsDiploma = [];
    public static $reservedCertificatesIds=[];
    //public static $allCertificatIds=[];
    public function run(): void
    {
       // $this->call(UserSeeder::class);
        $users = collect(UserSeeder::$users);

        $numberOfStagiaires = $users->where('role', 'stagiaire')->count();

       if( $numberOfStagiaires>0)
       {
           // Create certificates for each status
           
           $undeliveredCertificatesBac = Certificat::factory(31)->create(['status' => 'undelivered']);
           $undeliveredCertificatesDiploma = Certificat::factory(46)->create(['status' => 'undelivered']);
           $deliveredCertificatesBac = Certificat::factory(30)->create(['status' => 'delivered']);
           $deliveredCertificatesDiploma = Certificat::factory(46)->create(['status' => 'delivered']);
           $reservedCertificates = Certificat::factory(31)->create(['status' => 'reserved']);
   
           // Store the IDs in the static properties
           self::$undeliveredCertificatIdsBac = $undeliveredCertificatesBac->pluck('id')->toArray();
           self::$undeliveredCertificatIdsDiploma = $undeliveredCertificatesDiploma->pluck('id')->toArray();
           self::$deliveredCertificatIdsBac = $deliveredCertificatesBac->pluck('id')->toArray();
           self::$deliveredCertificatIdsDiploma = $deliveredCertificatesDiploma->pluck('id')->toArray();
           self::$reservedCertificatesIds = $reservedCertificates->pluck('id')->toArray();

            // Merge both into one array (e.g. for reference or combined operations)
          // self::$allCertificatIds = $undeliveredCertificates->merge($deliveredCertificates);
    }
       
   }
    

    // public static function createCertificats():array
    // {
    //      $users = collect(UserSeeder::createUsers(10));

    //     $numberOfStagiaires = $users->where('role', 'stagiaire')->count();

    //     // Create certificates for each status and get their instances
    //     $undeliveredCertificates = Certificat::factory($numberOfStagiaires)->create(['status' => 'undelivered']);
    //     $deliveredCertificates = Certificat::factory($numberOfStagiaires)->create(['status' => 'delivered']);

    //     // Return the separate lists of Certificat IDs
    //     return [
    //         'undelivered' => $undeliveredCertificates->pluck('id')->toArray(),
    //         'delivered' => $deliveredCertificates->pluck('id')->toArray(),
    //     ];
    // }
}
