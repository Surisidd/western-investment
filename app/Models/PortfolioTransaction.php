<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'PortfolioTransactionID';
    protected $connection = 'sqlsrv';

    public function portfolio(){
      return $this->belongsTo(Portfolio::class,'PortfolioID');
    }

    public function security(){
        return $this->belongsTo(Security::class, 'SecurityID1','SecurityID');
    }

    public function transaction(){
      return $this->belongsTo(TransactionCode::class,'TransactionCode', 'TransactionCode');
    }

    public function securityType(){
      return $this->belongsTo(SecurityType::class,'SecTypeCode1','SecTypeBaseCode');
    }

  protected $table = 'AdvPortfolioTransaction';
  
}
