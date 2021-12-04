<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $table='AdvPriceHistory';
    protected $connection = 'sqlsrv';


    // FromDate 

    protected $casts = [
        'FromDate' => 'date:Y-m-d',
    ];

}
