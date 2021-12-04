<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSummary extends Model

{

    protected $fillable=[
        'client',
        'fund',
        'startValue',
        'contributions',
        'redemption',
        'return',
        'email1',
        'endValue',
        'status',
        'error'
    ];
    use HasFactory;
}
