<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailActivity extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable=['user_id','ContactID','email','endPortfolio','status','desc','schedule_id'];

    public function contact(){
        return $this->belongsTo(Contact::class,'ContactID');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
