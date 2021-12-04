<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;

class ContactSchedule extends Model
{
    protected $fillable=['schedule_id'];


    protected $connection = 'mysql';



    public function schedule(){
        return $this->belongsTo(schedule::class);
    }


    public function contact(){
        return $this->belongsTo(Contact::class,'ContactID','ContactID');
    }
    use HasFactory;
}
