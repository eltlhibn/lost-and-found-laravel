<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VerificationAnswer;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'user_id',
        'item_name',
        'description',
        'photo',
        'location',
        'report_type',
        'verification_question',
        'date_lost_found',
        'contact_info',
        'status',
    ];

    protected $casts = [
        'date_lost_found' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function answers()
    {
        return $this->hasMany(VerificationAnswer::class);
    }
}
