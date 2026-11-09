<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Report;
use App\Models\VerificationAnswer;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function reports()
    {
        return $this->hasMany(Report::class);
    }

   
    public function verificationAnswers()
    {
        return $this->hasMany(VerificationAnswer::class);
    }
}
