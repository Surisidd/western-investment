<?php

use App\Models\ClientSummary;
use App\Models\CurrencyRate;
use App\Models\Security;

use Illuminate\Support\Facades\DB;

function interests($amount,$security,$settleDate,$endDate){
    $security=Security::find($security);
    $dailyRate=(15/100)/365;

    $startDatex = new \DateTime($settleDate);  
    $endDatex = new \DateTime($endDate);

    if($security->MaturityDate >= $endDate){
        $days = $startDatex->diff($endDatex)->days;
        $interest=$dailyRate*$days*$amount;

    } else{
        $matx=date("Y-m-d", strtotime($security->MaturityDate));
        $mat=new DateTime($matx);
        $days=$startDatex->diff($mat)->days;
        $interest=$dailyRate*$days*$amount;

    }

    return $interest;
}

function monthlyinterests($amount,$security,$startDate, $endDate){
    $security=Security::find($security);
    $dailyRate=(15/100)/365;

    $startDatex = new \DateTime($startDate);  
    $endDatex = new \DateTime($endDate);

    if($security->MaturityDate >= $endDate){

        $days = $startDatex->diff($endDatex)->days;
        $interest=$dailyRate*$days*$amount;

    } else {
        $interest=0;
    }

    return $interest;
}

function currency_rate($date,$fromCurrency, $toCurrency){
    $spotRate=DB::connection('sqlsrv')->select('
    select SpotRate from AdvApp.vFXRate where 
    PriceDate=? AND DenominatorCurrencyCode=? and 
                                    NumeratorCurrencyCode=?
    ',[
        $date,
        $fromCurrency,
        $toCurrency
    ]);
    return $spotRate[0]->SpotRate;
}
function securityPrice($securityID,$date){
    $price=DB::connection('sqlsrv')->select('Select PriceValue from AdvPriceHistory where SecurityID=? AND FromDate=?', [$securityID,$date]);
    return $price[0]->PriceValue;
}











