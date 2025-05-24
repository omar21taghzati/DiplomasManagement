<?php

namespace App\Models;

use App\Models\Certificat;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    /** @use HasFactory<\Database\Factories\StatisticFactory> */
    use HasFactory;

     protected $fillable = [
       'stagiaire_id',
        'additional_notes',
         'taken_date',
         'type_cerf',
       'user_id',
       'certificat_id',
       'taking_duration',
       'return_date',
        
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    
    public function certificat()
    {
        return $this->belongsTo(Certificat::class);
    }
}
