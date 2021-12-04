<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;

class CurrencyRateController extends Controller
{

    public function index()
    {
        return view('currencyrates.index',[
            'rates'=>CurrencyRate::all()
        ]);
    }

   
}
