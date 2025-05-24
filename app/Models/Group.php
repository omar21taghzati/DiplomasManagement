<?php

namespace App\Models;

use App\Models\Filier;
use App\Models\Stagiaire;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;
    public function filier()
    {
        return $this->belongsTo(Filier::class);
    }

    public function stagiaires():HasMany
    {
        return $this->hasMany(Stagiaire::class);
    }
}
