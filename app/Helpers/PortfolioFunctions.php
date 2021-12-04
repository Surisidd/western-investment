<?php

use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\ClientSummary;
use App\Transactions\Transactions;

function portfolio(Portfolio $portfolio, $startDate, $endDate)
{

    $startDate = $startDate;
    $endDate = $endDate;

    $transactions = $portfolio->transactions->load('security');
    if ($portfolio->contact->currency()->count() > 0) {
        $currency = $portfolio->contact->currency->currency;
    } else {
        $currency = "";
    }

    $contributions = 0;
    $bcontributions = 0;
    $withdrawals = 0;
    $tcontributions = 0;
    $twithdrawals = 0;
    $startValue = 0;
    $endValue = 0;
    $totalUnits = 0;
    $marketValue = 0;

    // NIF
    $prev_interest = 0;
    $interest = 0;

    if (!empty($transactions->firstWhere("TransactionCode", "by")->security)) {
        $startPrice = $transactions->firstWhere("TransactionCode", "by")->security->price($startDate);
        $endPrice = $transactions->firstWhere("TransactionCode", "by")->security->price($endDate);
    }

    $mutualFunds = $transactions->filter(function ($transaction) {
        return $transaction->SecTypeCode1 === "mf";
    });

    $NIF = $portfolio->transactions->filter(function ($transaction) {
        return $transaction->SecTypeCode1 === "ck";
    });

    if (($mutualFunds)->count() > 0) {

        foreach ($transactions as $transaction) {

            //    Contributions
            if ($transaction->TransactionCode === "li" &&  $transaction->TradeDate >= $startDate && $transaction->TradeDate <= $endDate) {
                $contributions += $transaction->TradeAmount;
            }

            // Bought contributions
            if ($transaction->TransactionCode === "by" &&  $transaction->TradeDate > $startDate && $transaction->TradeDate <= $endDate) {
                $bcontributions += $transaction->TradeAmount;
            }

            // TIContributions
            if ($transaction->TransactionCode === "ti"  &&  $transaction->TradeDate >= $startDate && $transaction->TradeDate <= $endDate) {
                $tcontributions += $transaction->TradeAmount;
            }

            // Withdrawals
            if ($transaction->TransactionCode === "lo" &&  $transaction->TradeDate > $startDate && $transaction->TradeDate <= $endDate) {
                $withdrawals += $transaction->TradeAmount;
            }

            //To Withdrawals
            if ($transaction->TransactionCode === "to"  &&  $transaction->TradeDate >= $startDate && $transaction->TradeDate <= $endDate) {
                $twithdrawals += $transaction->TradeAmount;
            }
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $endDate) {
                $totalUnits -= $transaction->Quantity;
            }

            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $startDate) {  //Buying Units ++++

                if ($currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($currency === "kes") {
                    if ($transaction->security->PrincipalCurrencyCode === "ke") {  //if the security is in KES, maintain
                        $startValue += $transaction->Quantity * $startPrice;
                    } elseif ($transaction->security->PrincipalCurrencyCode === "us") {
                        $startValue += ($transaction->Quantity * $startPrice) * currency_rate();
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } else {
                    $startValue += $transaction->Quantity * ($startPrice);
                }
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $startDate) {
                if ($currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($currency === "kes") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * (currency_rate() * $startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } else {
                        $startValue -= $transaction->Quantity * (currency_rate() * $startPrice);
                    }
                } else {
                    $startValue -= $transaction->Quantity * ($startPrice);
                }
            }
            // End Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $endDate) {  //Buying Units ++++

                if ($currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($currency === "kes") {
                    if ($transaction->security->PrincipalCurrencyCode === "ke") {  //if the security is in KES, maintain
                        $endValue += $transaction->Quantity * $endPrice;
                    } elseif ($transaction->security->PrincipalCurrencyCode === "us") {
                        $endValue += $transaction->Quantity * ($endPrice * currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } else {

                    $endValue += $transaction->Quantity * ($endPrice);
                }
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $endDate) {
                if ($currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($currency === "kes") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * (currency_rate() * $endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } else {
                    $endValue -= $transaction->Quantity * ($endPrice);
                }
            }
            // Market Value
            $marketValue = $totalUnits * $endPrice;

            $data = [
                "startDate" => $startDate,
                "endDate" => $endDate,
                "unitCost" => $startPrice,
                "marketPrice" => $endPrice,
                "Name" => $transactions->firstWhere("TransactionCode", "by"),
                "portfolio" => $portfolio,
                "startValue" => $startValue,
                "currency"=> $transactions->firstWhere("TransactionCode", "by")->security->PrincipalCurrencyCode,
                "transactions" => $transactions->where("TradeDate", ">=", $startDate),
                "endValue" => $endValue,
                "interest" => $endValue - ($startValue + ($bcontributions - $withdrawals )),
                "withdrawals" => $withdrawals+$twithdrawals,
                "contributions" => $contributions+$tcontributions,
                "twithdrawals" => $twithdrawals,
                "tcontributions" => $tcontributions,
                "TotalMarket" => $marketValue,
                "TotalUnits" => $totalUnits
            ];
        }
        return $data;
    } elseif ($NIF->count() > 0) {
        $fdtransactions=new Transactions($portfolio->contact,$startDate,$endDate);
        $fixedIncome=$fdtransactions->fixedIncome();


        $NIFTransactions = $transactions->where('SecTypeCode1', 'ck')->where('SecurityID2', '177')->where('TradeAmount', '>', 0)->where('TransactionCode', 'by');
        $data = [
            "startDate" => $startDate,
            "endDate" => $endDate,
            "portfolio" => $portfolio,
            "Name" => $transactions->firstWhere("TransactionCode", "by"),
            "currency"=> $transactions->firstWhere("TransactionCode", "by")->security->PrincipalCurrencyCode,
            "startValue" => $fixedIncome[0]["startValue"],
            "transactions" => $NIF,
            "endValue" => $fixedIncome[0]["endValue"],
            "contributions" => $fixedIncome[0]["bought"]+$tcontributions,
            "interest" => $fixedIncome[0]["interest"],
            "withdrawals" => $fixedIncome[0]["sold"],
            "twithdrawals" => $twithdrawals,
            "tcontributions" => $tcontributions,
            "TotalMarket" => $fixedIncome[0]["endValue"],
            "TotalUnits" => 0
        ];
        return  $data;
    } else {

        return NULL;
    }
}

function portfolioPDF(Portfolio $portfolio, $startDate = "", $endDate = "")
{

    if (empty($startDate) && empty($endDate)) {
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
    }

    $data = ["data" => portfolio($portfolio, $startDate, $endDate)];
    $config = ['instanceConfigurator' => function ($mpdf) {
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->use_kwt = true;    // Default: false
    }];

    $pdf = \PDF::loadView('statements.statement_pdf', $data, [], $config);
    $pdf->SetProtection(['copy', 'print'], $portfolio->contact->password(), '040404');
    return $pdf;
}

function consolidatedPDF(Contact $contact, $startDate, $endDate)
{
    if (empty($startDate) && empty($endDate)) {
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
    }

    $config = ['instanceConfigurator' => function ($mpdf) {
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->use_kwt = true;    // Default: false
    }];

    $transactions=new Transactions($contact,$startDate,$endDate);
    $mutualFunds=$transactions->mutualfunds();
    $equities=$transactions->equities();
    $fixedDeposits=$transactions->fixedDeposits();
    $fixedIncome=$transactions->fixedIncome();
    $latestTransactions=$transactions->latestTransactions();

    $summary=$transactions->summary();

    $pdf = \PDF::loadView('statements.test.consolidated', [
        'startDate' => $startDate,
        "endDate" => $endDate,
        "contact" => $contact,
        "summary"=>$summary,
        "mutualfunds"=>$mutualFunds,
        "equities"=>$equities,
        "fixedDesposits"=>$fixedDeposits,
        "latestTransactions"=>$latestTransactions,
        "fixedincome"=>$fixedIncome
    ], [], $config);
    $pdf->SetProtection(['copy', 'print'], $contact->password(), '040404');
    return $pdf;
}

function portfolioSummaryPDF(ClientSummary $client)
{

        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
    $data = ["data" => $client];

    $config = ['instanceConfigurator' => function ($mpdf) {
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->use_kwt = true;    // Default: false
    }];


    // /home/tango/Projects/Western V/Western-apx-dashboard/resources/views/statements/statement-summary.blade.php

    $pdf = \PDF::loadView('statements.summary', $data, [], $config);
    // $pdf->SetProtection(['copy', 'print'], $portfolio->contact->password(), '040404');
    return $pdf;
}
