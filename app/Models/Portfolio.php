<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    protected $primaryKey = 'PortfolioID';
    // public $incrementing = false;


    public function transactions(){
        return $this->hasMany(PortfolioTransaction::class, 'PortfolioID')->select(['PortfolioID','PortfolioTransactionID','TradeDate','TransactionCode','SecTypeCode1','SecurityID1','SettleDate','Quantity','SecTypeCode2','SecurityID2','TradeAmount']);
    }

    public function holding_history(){
        return $this->hasMany(PortfolioHoldingHistory::class,'PortfolioID');
    }


    public function contact(){
        return $this->belongsTo(Contact::class,'PrimaryContactID');
    }



  protected $casts = [
    'StartDate' => 'datetime:Y-m-d H:00',
];
}
