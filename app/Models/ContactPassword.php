<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ContactPassword extends Model
{


    protected $connection = 'mysql';
    use HasFactory;

    protected $fillable=['password','user_id'];

    public function contact(){  
        return $this->belongsTo(Contact::class,'ContactID');
    }
}
