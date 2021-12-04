<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRate extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table='AdvDateRate';

    protected $primaryKey = 'DateRateID';


    public function schedule(){
        return $this->hasOne(DateRateSchedule::class,'DateRateID','DateRateID');
    }

}
