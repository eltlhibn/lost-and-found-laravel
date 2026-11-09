<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Report;

class VerificationAnswer extends Model
{
    use HasFactory;

    protected $table = 'verification_answers';

    protected $fillable = [
        'report_id',
        'user_id',
        'answer',
        'status',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
