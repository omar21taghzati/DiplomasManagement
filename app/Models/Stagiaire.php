<?php

namespace App\Models;

use App\Models\Bac;
use App\Models\Diploma;
use App\Models\Group;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    /** @use HasFactory<\Database\Factories\StagiaireFactory> */
    use HasFactory;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bac()
    {
        return $this->belongsTo(Bac::class,'bac_id');
        //this bac_id belongs to Stagiaire table
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function statistics():HasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
