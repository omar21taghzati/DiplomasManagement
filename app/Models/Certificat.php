<?php

namespace App\Models;

use App\Models\Bac;
use App\Models\Diploma;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    /** @use HasFactory<\Database\Factories\CertificatFactory> */
    use HasFactory;
    public function statistics():HasMany
    {
        return $this->hasMany(Statistic::class,'certificat_id');
        //this certificat_id belongs to table Statistics
    }
    public function bac()
    {
        return $this->hasOne(Bac::class);
    }

    public function diploma()
    {
        return $this->hasOne(Diploma::class);
    }
}
