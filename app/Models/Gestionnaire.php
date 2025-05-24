<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    /** @use HasFactory<\Database\Factories\GestionnaireFactory> */
    use HasFactory;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
