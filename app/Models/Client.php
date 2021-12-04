<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDF;

class Client extends Model
{
    use HasFactory;
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function statementPDF(){

        // get data from APX
        $data=[
            'name'=>$this->name,
            'portfolio_name'=>$this->portfolio_name,
            'client_no'=>$this->client_no

        ];

        $pdf = PDF::loadView('statements.statement_pdf', $data);
        $pdf->SetProtection(array(),$this->client_id, '');
        return $pdf;
    }

    public function emailactivities(){
        return $this->hasMany(ClientEmailActivity::class);
    }

    public function latestEmail($id){
        return ClientEmailActivity::where('user_id',$id)->latest()->get();
    }

  
   
}
