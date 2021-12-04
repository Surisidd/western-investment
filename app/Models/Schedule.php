<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{


    use HasFactory;
    protected $fillable=['status','approved_by','email'];

    public function approver(){
        return $this->belongsTo(User::class,'approved_by');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function emails(){
        return $this->hasMany(EmailActivity::class);
    }

    public function contactSchedules()
    {
        return $this->hasMany(ContactSchedule::class);
    }

    public function scopeHourly($query){
        return $query->where('frequency','hourly')->where('status','approved');
    }
    public function scopeWeekly($query){
        return $query->where('frequency','weekly');
    }
    public function scopeMonthly($query){
        return $query->where('frequency','monthly');
    }

    public function scopeQuaterly($query){

        return $query->where('frequency','quarterly');
    }

    public function scopeYearly($query){
        return $query->where('frequency','yearly');
    }

    public function scopePending($query)
    {
        return $query->where('status','pending');
    }


    protected static function booted()
    {
        static::deleting(function ($schedule) {
            $schedule->emails()->delete();
            $schedule->contactSchedules()->delete();

        });
    }


}
