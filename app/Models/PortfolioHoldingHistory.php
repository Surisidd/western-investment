<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioHoldingHistory extends Model
{
    use HasFactory;

    protected $table='AdvHoldingHistory';

    protected $casts = [
        'HeldFromDate' => 'datetime:Y-m-d H:00',
        'HeldThruDate' => 'datetime:Y-m-d H:00',
        'LatestSettleDate' =>'datetime:Y-m-d H:00',
    ];

}
