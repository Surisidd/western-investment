<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCurrency extends Model
{
    use HasFactory;


    protected $connection = 'mysql';

    protected $fillable=['currency'];

    public function contact()
    {
        return $this->belongsTo(Contact::class,'ContactID');
    }
}
