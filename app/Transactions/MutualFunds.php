<?php

namespace App\Transactions;

use App\Models\Contact;
use App\Models\PortfolioTransaction;
use Illuminate\Support\Facades\DB;

class MutualFunds
{

    function __construct($transactions, $startDate, $endDate, $currency)
    {

        $this->transactions = $transactions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->currency = $currency;
    }

    // 308==>Angani Fund MF000001 ID: 308


    // 460==>Western Africa Money Market Fund MF000002 ID: 460
    function WesternAfricaMoneyMarket()
    {
        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "460";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 460)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 460)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western Africa Money Market Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];
        return $data;
    }

    // 461==>Western Africa Balanced Fund MF000003 ID: 461
    function WesternAfricaBalanced()
    {
        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "461";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 461)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 461)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western Africa Balanced Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];
        return $data;
   
    }

    // 462==>Western Africa Equity Fund MF000004 ID: 462
    function WesternAfricaEquity()
    {

        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "462";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 462)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 462)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western Africa Equity Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];
        return $data;
   
    }

    // 463==>Western Africa Fixed Income Fund MF000005 ID: 463
    function WesternAfricaFixedIncome()
    {

        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "463";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 463)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 463)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western Africa Money Market Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];
        return $data;
   
    }

    // 13775==>Western KES Money Market Fund MF000010 ID: 13775
    function WesternKESMoneyMarket()
    {
        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "13775";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 13775)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 13775)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western KES Money Market Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];

        return $data;
    }

    // 17246==>Western KES Fixed Income Fund MF000011 ID: 17246
    function WesternKESFixedIncome()
    {

        $startValue = 0;
        $endValue = 0;
        $startPrice = 0;
        $endPrice = 0;
        $interest = 0;
        $totalUnits = 0;
        $endValue = 0;

        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "17246";
        });


        $startPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 17246)
            ->whereDate("FromDate", $this->startDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        $endPrice = DB::connection('sqlsrv')->table('AdvPriceHistory')
            ->where("SecurityID", 17246)
            ->whereDate("FromDate", $this->endDate)
            ->select("PriceValue")
            ->limit(1)
            ->get()
            ->pluck("PriceValue")[0];

        foreach ($filtered as $transaction) {
            // Total Units
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits += $transaction->Quantity;
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                $totalUnits -= $transaction->Quantity;
            }
            // Start Value
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->startDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $startValue += $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue += $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue += $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->startDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $startValue -= $transaction->Quantity * ($startPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $startValue -= $transaction->Quantity * ($startPrice / currency_rate());
                    } else {
                        $startValue -= $transaction->Quantity * $startPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $this->endDate) {  //Buying Units ++++

                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                        $endValue += $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue += $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue += $transaction->Quantity * $endPrice;
                    }
                } elseif ($this->currency === "kes") {
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
            } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $this->endDate) {
                if ($this->currency === "usd") {
                    if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                        $endValue -= $transaction->Quantity * ($endPrice);
                    } elseif ($transaction->security->PrincipalCurrencyCode === "ke") {
                        $endValue -= $transaction->Quantity * ($endPrice / currency_rate());
                    } else {
                        $endValue -= $transaction->Quantity * ($endPrice);
                    }
                } elseif ($this->currency === "kes") {
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
        }

        $data = [
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "unitCost" => $startPrice,
            "marketPrice" => $endPrice,
            "Name" => "Western KES Fixed Income Fund",
            "startValue" => $startValue,
            "endValue" => $endValue,
            "interest" => $endValue - $startValue,
            "TotalUnits" => $totalUnits
        ];
        return $data;
   
    }

    /* Cash and Equivalents  */
    // CFC Stanbic Cash CFCCashKES ID: 177
    function stanbicCashKES(){

    }

    // 6985==>EQUITY BANK Custody Cash Account EQTYCashKES ID: 6985
    function equityBankCustody(){
        $startValue=0;
        $filtered = $this->transactions->filter(function ($transaction) {
            return $transaction->SecurityID1 === "6985";
        });


        // lo,by,ti,to
        foreach($filtered as $transaction){
            if ($transaction->TradeDate < $this->startDate) {
                $startValue += $transaction->TradeAmount*$transaction->transaction->EffectOnQuantity;
            } 
        }
        return $startValue;
    }

    function fixedDeposits(){

        $fd=$this->transactions->filter(function($transaction){
            return !empty($transaction->security);
        });
        $filtered = $fd->filter(function ($transaction) {
            return $transaction->security->SecTypeBaseCode === "fd" && $transaction->security->MaturityDate >=$this->startDate;
        });

        return $filtered;
    }
    function equities(){
         $cs=$this->transactions->filter(function($transaction){
        return !empty($transaction->security);
    });
        $equities = $cs->filter(function ($transaction) {
            return $transaction->security->SecTypeBaseCode === "cs";
        });

        // foreach($equities as $equity){
        //     $startValue=0;
        //     $endValue=0;
        //     foreach($equity->transactions as $transaction){
        //         $quantity=0;
        //         $quantity+=$equity->Quantity*$equity->transaction->EffectOnQuantity;
        //     }
        // }

        $totalPerEquity = [];
        foreach($equities as $key => $value){
            $totalPerEquity[] = [
                'Equity' => $value->security->FullName,
                'Quantity' =>$value->Quantity + $totalPerEquity[$key]["Quantity"],
                'TradeAmount' => $value->TradeAmount + $totalPerEquity[$key]['TradeAmount']
            ];
        }


        return $totalPerEquity;
        
    }
}
