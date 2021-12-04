<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $table='vAdvFxRateLatest';

    protected $casts = [
        'AsOfDate' => 'datetime:Y-m-d',
    ];
}
