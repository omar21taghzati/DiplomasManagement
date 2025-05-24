<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Secteur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filier extends Model
{
    /** @use HasFactory<\Database\Factories\FilierFactory> */
    use HasFactory;

    public function secteur():BelongsTo
    {
        return $this->belongsTo(Secteur::class);
    }

    public function groups():HasMany
    {
        return $this->hasMany(Group::class);
    }

    
}
