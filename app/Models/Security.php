<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    protected $primaryKey = 'SecurityID';

    protected $connection = 'sqlsrv';

    public function pricehistories(){
        return $this->hasMany(PriceHistory::class,'SecurityID','SecurityID')->select(['FromDate','SecurityID','PriceValue']);
    }

    public function pricetoday(){

        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );

        if($this->pricehistories()->whereDate('FromDate', $yesterday)->first()){
            return $this->pricehistories()->whereDate('FromDate', $yesterday)->first()->PriceValue;
        } else{  
                return $this->pricehistories()->latest('FromDate')->first()->PriceValue;
        }
    }

    public function price($date){
        if($this->pricehistories()->whereDate('FromDate', $date)->first()) {
            return $this->pricehistories()->whereDate('FromDate', $date)->first()->PriceValue;     
        } else{
            return 0;
        }
    }

    public function securityType(){
        return $this->belongsTo(SecurityType::class,'SecTypeBaseCode','SecTypeBaseCode');
    }

    public function daterate(){
        return $this->hasOne(DateRate::class,'DateRateName','Symbol');
    }

   public function transactions(){
       return $this->hasMany(PortfolioTransaction::class,'SecurityID1','SecurityID');
   }

    protected $table='AdvSecurity';

}
