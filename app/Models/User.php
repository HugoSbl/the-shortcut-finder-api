<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','email','password','pseudo','params','image','date_of_inscription'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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


    //Relation avec shortcuts
    public function shortcuts()
    {
        // Un user peut avoir plusieurs shortcuts
        return $this->hasMany(Shortcut::class);
    }

    // Relation avec comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec propositions
    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }

    // Relation avec reports
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
