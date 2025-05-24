<?php

namespace App\Models;

use App\Models\Certificat;
use App\Models\Stagiaire;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bac extends Model
{
    /** @use HasFactory<\Database\Factories\BacFactory> */
    use HasFactory;

    public function certificat()
    {
        return $this->belongsTo(Certificat::class);
    }
    
    public function stagiaire()
    {
        return $this->hasOne(Stagiaire::class);
    }
}
