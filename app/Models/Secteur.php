<?php

namespace App\Models;

use App\Models\Filier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    /** @use HasFactory<\Database\Factories\SecteurFactory> */
    use HasFactory;

    public function filiers():HasMany
    {
        return $this->hasMany(Filier::class,'secteur_id');
        //this secteur_id belongs to filier
    }
}
