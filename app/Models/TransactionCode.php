<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCode extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';


    public function name(){
        if($this->TransactionCode === 'li'){
            return "Contributions";
        }elseif($this->TransactionCode === 'lo'){
            return "Redemption";
        } else{
            return $this->TranCodeLabel;
        }
    }
    protected $table = 'AdvTransactionCode';

    // TransactionCode: "hs",
    // TranCodeLabel: "Holding Short",
    // EffectOnQuantity: "0",
    // IsAllowedInTransaction: "0",
    // AuditEventID: "1",
    // AuditTypeCode: "I",

}
