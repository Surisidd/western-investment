<?php

use App\Models\Contact;
use App\Models\Portfolio;

function portfolio(Portfolio $portfolio,$startDate,$endDate){

    $startDate = $startDate;
    $endDate = $endDate;

    $transactions = $portfolio->transactions->load('security');
    if ($portfolio->contact->currency()->count() > 0) {
        $currency = $portfolio->contact->currency->currency;
    } else {
        $currency = "";
    }

    $mutualFunds = $transactions->filter(function ($transaction) {
        return $transaction->SecTypeCode1 === "mf";
    });

    $NIF = $portfolio->transactions->filter(function ($transaction) {
        return $transaction->SecTypeCode1 === "ck";
    });

    if (($mutualFunds)->count() > 0) {
    
        $summaryMutualFunds = $mutualFunds->map(function ($transaction) use ($startDate, $endDate) {
            return [
                "SecType" => $transaction->SecTypeCode1,
                "Name" => $transaction->security->FullName,
                "Currency" => $transaction->security->PrincipalCurrencyCode,
                "TradeAmount" => $transaction->TradeAmount,
                "TradeDate" => $transaction->TradeDate,
                "MarketPrice" => $transaction->security->price($endDate),
                "Units" => $transaction->Quantity * $transaction->transaction->EffectOnQuantity,
                "UnitCost" => $transaction->security->price($startDate),
                "TotalCost" => $transaction->security->price($startDate) * ($transaction->Quantity * $transaction->transaction->EffectOnQuantity),
                "MarketPrice" => $transaction->security->price($endDate),
                "TotalMarketValue" => $transaction->security->price($endDate) * ($transaction->Quantity * $transaction->transaction->EffectOnQuantity)
            ];
        });

        // StartValue
        $startPortfolio=0;
        for ($i = 0; $i < $transactions->count(); $i++) {
            if ($transactions[$i]->TransactionCode === 'by' && $transactions[$i]->TradeDate < $startDate) {
                if (
                    $transactions[$i]->security->Symbol === "MF000010"
                    || $transactions[$i]->security->Symbol === "MF000011"
                    || $transactions[$i]->security->Symbol === "MF000002"
                    || $transactions[$i]->security->Symbol === "MF000003"
                    || $transactions[$i]->security->Symbol === "MF000004"
                    || $transactions[$i]->security->Symbol === "MF000005"
                ) {
                    if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {
                        if ($currency === "usd") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                            } else {
                                $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            }
                        } elseif ($currency === "kes") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            } else {
                                $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            }
                        } else {
                            $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                        }
                    } else {
                        $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                    }
                }
            } elseif ($transactions[$i]->TransactionCode === 'sl' && $transactions[$i]->SettleDate < $startDate) {
                if (
                    $transactions[$i]->security->Symbol === "MF000010"
                    || $transactions[$i]->security->Symbol === "MF000011"
                    || $transactions[$i]->security->Symbol === "MF000002"
                    || $transactions[$i]->security->Symbol === "MF000003"
                    || $transactions[$i]->security->Symbol === "MF000004"
                    || $transactions[$i]->security->Symbol === "MF000005"
                ) {
                    if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {

                        if ($currency === "usd") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                            } else {
                                $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            }
                        } elseif ($currency === "kes") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            } else {
                                $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                            } $startPortfolio = 0;
                            for ($i = 0; $i < $transactions->count(); $i++) {
                                if ($transactions[$i]->TransactionCode === 'by' && $transactions[$i]->TradeDate <= $startDate) {
                                    if (
                                        $transactions[$i]->security->Symbol === "MF000010"
                                        || $transactions[$i]->security->Symbol === "MF000011"
                                        || $transactions[$i]->security->Symbol === "MF000002"
                                        || $transactions[$i]->security->Symbol === "MF000003"
                                        || $transactions[$i]->security->Symbol === "MF000004"
                                        || $transactions[$i]->security->Symbol === "MF000005"
                                    ) {
                
                                        if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {
                                            if ($currency === "usd") {
                                                if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                                    $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                                } else {
                                                    $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                }
                                            } elseif ($currency === "kes") {
                                                if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                                    $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                } else {
                                                    $startPortfolio += $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                }
                                            } else {
                                                $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                            }
                                        } else {
                                            $startPortfolio += $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                        }
                                    }
                                } elseif ($transactions[$i]->TransactionCode === 'sl' && $transactions[$i]->SettleDate <= $startDate) {
                                    if (
                                        $transactions[$i]->security->Symbol === "MF000010"
                                        || $transactions[$i]->security->Symbol === "MF000011"
                                        || $transactions[$i]->security->Symbol === "MF000002"
                                        || $transactions[$i]->security->Symbol === "MF000003"
                                        || $transactions[$i]->security->Symbol === "MF000004"
                                        || $transactions[$i]->security->Symbol === "MF000005"
                                    ) {
                                        if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {
                
                                            if ($currency === "usd") {
                                                if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                                    $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                                } else {
                                                    $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                }
                                            } elseif ($currency === "kes") {
                                                if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, maintain
                                                    $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                } else {
                                                    $startPortfolio -= $transactions[$i]->Quantity * (currency_rate() * $transactions[$i]->security->price($startDate));
                                                }
                                            } else {
                                                $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                            }
                                        } else {
                                            $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                                        }
                                    }
                                }
                            }
                        } else {
                            $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                        }
                    } else {
                        $startPortfolio -= $transactions[$i]->Quantity * ($transactions[$i]->security->price($startDate));
                    }
                }
            }
        }


        // End Value
        $endPortfolio = 0;
        // Portfolio Value End date 
        for ($i = 0; $i < $transactions->count(); $i++) {
            if ($transactions[$i]->TransactionCode === 'by' && $transactions[$i]->TradeDate < $endDate) {
                if (
                    $transactions[$i]->security->Symbol === "MF000010"
                    || $transactions[$i]->security->Symbol === "MF000011"
                    || $transactions[$i]->security->Symbol === "MF000002"
                    || $transactions[$i]->security->Symbol === "MF000003"
                    || $transactions[$i]->security->Symbol === "MF000004"
                    || $transactions[$i]->security->Symbol === "MF000005"
                ) {

                    if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {

                        if ($currency === "usd") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            } else {
                                $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            }
                        } elseif ($currency === "kes") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate) * currency_rate();
                            } else {
                                $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            }
                        } else {
                            $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                        }
                    } else {
                        $endPortfolio += $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                    }
                }
            } elseif ($transactions[$i]->TransactionCode === 'sl' && $transactions[$i]->SettleDate <= $endDate) {
                if (
                    $transactions[$i]->security->Symbol === "MF000010"
                    || $transactions[$i]->security->Symbol === "MF000011"
                    || $transactions[$i]->security->Symbol === "MF000002"
                    || $transactions[$i]->security->Symbol === "MF000003"
                    || $transactions[$i]->security->Symbol === "MF000004"
                    || $transactions[$i]->security->Symbol === "MF000005"
                ) {


                    if ($transactions[$i]->security->Symbol === "MF000002" || $transactions[$i]->security->Symbol === "MF000003" || $transactions[$i]->security->Symbol === "MF000004" || $transactions[$i]->security->Symbol === "MF000005") {

                        if ($currency === "usd") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            } else {
                                $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            }
                        } elseif ($currency === "kes") {
                            if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate) * currency_rate();
                            } else {
                                $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                            }
                        } else {
                            $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                        }
                    } else {
                        $endPortfolio -= $transactions[$i]->Quantity * $transactions[$i]->security->price($endDate);
                    }
                }
            }
        }
        
    // Withdrawals
        $withdrawals = 0;
        for ($i = 0; $i < $transactions->count(); $i++) {
            if ($transactions[$i]->TransactionCode === 'sl' &&  $transactions[$i]->TradeDate >= $startDate && $transactions[$i]->TradeDate < $endDate) {
                if (
                    $transactions[$i]->security->Symbol === "MF000010"
                    || $transactions[$i]->security->Symbol === "MF000011"
                    || $transactions[$i]->security->Symbol === "MF000002"
                    || $transactions[$i]->security->Symbol === "MF000003"
                    || $transactions[$i]->security->Symbol === "MF000004"
                    || $transactions[$i]->security->Symbol === "MF000005"
                ) {

                    if ($currency === "usd") {
                        if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                            if ($transactions[$i]->TotalCashInGlobalCurrency == "us") {
                                $withdrawals += $transactions[$i]->TradeAmount;
                            } elseif ($transactions[$i]->TotalCashInGlobalCurrency == "ke") {

                                $withdrawals += currency_rate() / $transactions[$i]->TradeAmount;
                            } else {
                                $withdrawals += $transactions[$i]->TradeAmount;
                            }
                        } else {
                            $withdrawals += $transactions[$i]->TradeAmount;
                        }
                    } elseif ($currency === "kes") {

                        if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                            if ($transactions[$i]->TotalCashInGlobalCurrency == "us") {
                                $withdrawals += $transactions[$i]->TradeAmount * currency_rate();
                            } elseif ($transactions[$i]->TotalCashInGlobalCurrency == "ke") {

                                $withdrawals += $transactions[$i]->TradeAmount;
                            } else {
                                $withdrawals += $transactions[$i]->TradeAmount;
                            }
                        } else {
                            $withdrawals += $transactions[$i]->TradeAmount;
                        }
                    } else {
                        $withdrawals += $transactions[$i]->TradeAmount;
                    }
                }
            }
        }

           // Contributions
            $contributions = 0;
            for ($i = 0; $i < $transactions->count(); $i++) {
                if ($transactions[$i]->TransactionCode === 'li' &&  $transactions[$i]->TradeDate >= $startDate && $transactions[$i]->TradeDate <= $endDate) {

                    // USD user
                            if ($currency === "usd") {
                                if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                    $contributions += $transactions[$i]->TradeAmount;

                                } elseif($transactions[$i]->security->PrincipalCurrencyCode === "ke") {
                                    $contributions += $transactions[$i]->TradeAmount/currency_rate();
                                } else{
                                    $contributions += $transactions[$i]->TradeAmount;

                                }
                // KES User
                            } elseif ($currency === "kes") {
                                if ($transactions[$i]->TotalCashInGlobalCurrency === "us") {
                                    $contributions += $transactions[$i]->TradeAmount * currency_rate();
                                } elseif ($transactions[$i]->TotalCashInGlobalCurrency == "ke") {
                                    $contributions += $transactions[$i]->TradeAmount;
                                } else {
                                    $contributions += $transactions[$i]->TradeAmount;
                                }


                // Normal as it is
                            } else {
                                // Check this security
                                $HoldingCurrency=$summaryMutualFunds->first();
                                if($HoldingCurrency["Currency"]==="us"){

                                    if ($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                        $contributions += $transactions[$i]->TradeAmount;
    
                                    } elseif($transactions[$i]->security->PrincipalCurrencyCode === "ke") {
                                        $contributions += $transactions[$i]->TradeAmount/currency_rate();
                                    } else{
                                        $contributions += $transactions[$i]->TradeAmount;
    
                                    }

                                } elseif($HoldingCurrency["Currency"]==="ke"){
                                    if ($transactions[$i]->security->PrincipalCurrencyCode === "ke") {
                                        $contributions += $transactions[$i]->TradeAmount;
    
                                    } elseif($transactions[$i]->security->PrincipalCurrencyCode === "us") {
                                        $contributions += $transactions[$i]->TradeAmount*currency_rate();
                                    } else{
                                        $contributions += $transactions[$i]->TradeAmount;
    
                                    }

                                } else{
                                    $contributions += $transactions[$i]->TradeAmount;

                                }


                              
                            }
                    
                }
            }

        $startValue=$startPortfolio;
        $endValue=$endPortfolio;
        $data = [
            "startDate" => $startDate,
            "endDate" => $endDate,
            "portfolio" => $portfolio,
            "Name" => $summaryMutualFunds->first(),
            "startValue" => $startValue,
            "transactions" => $transactions->where("TradeDate",">=",$startDate)->where("TradeDate","<=",$endDate),
            "endValue" => $endValue,
            "contributions" => $contributions,
            "interest" => $endValue - $startValue - $contributions+$withdrawals,
            "withdrawals" => $withdrawals,
            "TotalMarket" => $summaryMutualFunds->where("TradeDate","<=",$endDate)->sum("TotalMarketValue"),
            "TotalUnits" => $summaryMutualFunds->sum("Units")
        ];

        return  $data;
    
    } elseif ($NIF->count() > 0) {

        $dailyRate = (12.75 / 100) / 365;
    
        $endDatexx = new \DateTime($endDate);
        
        // Active NIFs
        $ActiveNIF=$NIF->filter(function($transaction) use($startDate,$endDate){
            return $transaction->SecurityID2 === "177" && $transaction->TransactionCode === 'by' && $transaction->security->MaturityDate >= $endDate;
        });
        
        // Previous  Interests  
        $prev_interests=$ActiveNIF->filter(function($nif)use($endDate){
            return  $nif->TransactionCode === 'by' && $nif->security->MaturityDate >= $endDate;
        })->map(function($nif) use($dailyRate,$startDate){
            return [
               "interest"=> $dailyRate*(new \DateTime($nif->SettleDate))->diff(new \DateTime($startDate))->days*$nif->Quantity];
        });
        
        // Start 
        $startValue=$ActiveNIF->filter(function($nif)use($startDate){
            return  $nif->SecurityID2 === "177"  && $nif->TransactionCode === 'by' &&  $nif->TradeDate <= $startDate;
        })->sum("TradeAmount")+$prev_interests->pluck("interest")->sum();

         $interest=0;
         for ($i = 0; $i < $transactions->count(); $i++) {

            if ($transactions[$i]->SecTypeCode1 === 'ck' && $transactions[$i]->SecurityID2 === '177' && $transactions[$i]->TransactionCode === 'by') {
                $startDatex = new \DateTime($startDate);

                $days = $startDatex->diff($endDatexx)->days;
                if ($days > 365) {
                    $interest += $dailyRate * 366 * $transactions[$i]->Quantity;
                } else {
                    $interest += $dailyRate * $days * $transactions[$i]->Quantity;
                }
            }
        }
        $contributions=0;
        $withdrawals=0;
        $endValue=$startValue+$interest;

        $NIFTransactions = $transactions->where('SecTypeCode1', 'ck')->where('SecurityID2', '177')->where('TradeAmount', '>', 0)->where('TransactionCode', 'by');
        $data = [
            "startDate" => $startDate,
            "endDate" => $endDate,
            "portfolio" => $portfolio,
            "Name" => [
                "Name"=>$NIF->first()->security->FullName],
            "startValue" => $startValue,
            "transactions" => $NIF,
            "endValue" => $endValue,
            "contributions" => $contributions,
            "interest" => $endValue - $startValue - $contributions,
            "withdrawals" => $withdrawals,
            "TotalMarket" => $startValue,
            "TotalUnits" => 0
        ];

        return  $data;
    

    } else {
        
        return NULL;
    }
}

 function portfolioPDF(Portfolio $portfolio,$startDate="",$endDate="")
{

    if (empty($startDate) && empty($endDate)) {
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
    }

    $data=["data"=>portfolio($portfolio,$startDate,$endDate)];
    $config = ['instanceConfigurator' => function ($mpdf) {
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->use_kwt = true;    // Default: false
    }];

    $pdf = \PDF::loadView('statements.statement_pdf',$data, [], $config);
    $pdf->SetProtection(['copy', 'print'],$portfolio->contact->password(), '040404');
    return $pdf;
}

function consolidatedPDF(Contact $contact,$startDate,$endDate){
    if (empty($startDate) && empty($endDate)) {
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
    }

    $config = ['instanceConfigurator' => function ($mpdf) {
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->use_kwt = true;    // Default: false
    }];

    $data=[
        "contact"=>$contact,
        "startDate"=>$startDate,
        "endDate"=>$endDate
    ];


    $pdf = \PDF::loadView('statements.consolidated',$data, [], $config);
    $pdf->SetProtection(['copy', 'print'],$contact->password(), '040404');
    return $pdf;
}












