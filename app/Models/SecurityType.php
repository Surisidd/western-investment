<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityType extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $primaryKey="SecTypeBaseCode";
    public $incrementing = false;
    protected $keyType = 'string';



    public function securities(){
        return $this->hasMany(Security::class,'SecTypeBaseCode','SecTypeBaseCode');
    }


    protected $table = 'vQbRowDefSecurityType';

}
