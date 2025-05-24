<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Directeur;
use App\Models\Gestionnaire;
use App\Models\Stagiaire;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'phone',
        'date_naissance',
        'about'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function gestionnaire()
    {
        return $this->hasOne(Gestionnaire::class);
    }

    public function directeur()
    {
        return $this->hasOne(Directeur::class);
    }

    public function stagiaire()
    {
        return $this->hasOne(Stagiaire::class);
    }

    public function statistics():HasMany
    {
        return $this->hasMany(Statistic::class,'user_id');
        //this user_id belongs to table Statistics
    }

    public function getType()
    {
        if($this->gestionnaire)
        {
            return 'gestionnaire';
        }

        if($this->directeur)
          return 'directeur';

        return 'stagiaire';
    }
}
