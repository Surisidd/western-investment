<?php

namespace App\TransactionTest;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class TransactionTest
{

  function __construct(Contact $contact, $startDate, $endDate)
  {
    $this->contact = $contact;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
  }

  function processTransactions($transactionCode)
  {
    return  DB::connection('sqlsrv')->select(
      'select t.SecurityID1,s.FullName,s.PrincipalCurrencyCode,ph.PriceValue as marketPrice,pph.PriceValue as unitPrice, 
                SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*pph.PriceValue ELSE 0 END) AS startValue,
                SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) AS startUnits,

                SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
                SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
                SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*ph.PriceValue ELSE 0 END) as endValue,
                SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) as endUnits,
                (SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*ph.PriceValue ELSE 0 END) 
                -(SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*pph.PriceValue ELSE 0 END)
                -SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END)
                +SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END))) AS interest


      from vQbRowDefContact c 
INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
INNER JOIN AdvApp.vPortfolioTransaction  t ON t.PortfolioID=p.PortfolioID
INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode

CROSS APPLY 
(
SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate= ?
) ph
CROSS APPLY 
(
SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate=?
) pph

where c.ContactID=? AND s.SecTypeBaseCode = ? 
GROUP BY t.SecurityID1,s.FullName, ph.PriceValue, pph.PriceValue,s.PrincipalCurrencyCode
HAVING 
      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) >0.5 
      OR  
      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) >0.5',
      [
        $this->startDate,
        $this->startDate,
        $this->startDate,
        $this->endDate,
        "sl",
        $this->startDate,
        $this->endDate,
        "by",
        $this->endDate,
        $this->endDate,
        $this->endDate,
        $this->startDate,
        $this->startDate,
        $this->endDate,
        "sl",
        $this->startDate,
        $this->endDate,
        "by",
        $this->endDate,
        $this->startDate,
        $this->contact->ContactID,
        $transactionCode,
        $this->startDate,
        $this->endDate
      ]
    );
  }

  function mutualfunds()
  {
    return $this->processTransactions("mf");
  }

  function equities()
  {
    return $this->processTransactions("cs");
  }

  function fixedDeposits()
  {
    $fixedDeposits = DB::connection('sqlsrv')->select('
    select t.SecurityID1,s.FullName,s.MaturityDate,drs.Rate,s.PrincipalCurrencyCode,tsb.TradeDate saleTradeDate,tsb.#Number,tsbs.TradeDate firstTradeDate, tsbsi.TradeAmount as interest,
    SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) AS startValue,
														SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
														SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
								SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) as endValue
								
from vQbRowDefContact c 
INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
LEFT JOIN (
	SELECT *
FROM
(
    SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
    FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
) th
WHERE th.#Number=1 AND th.TradeDate >= ?
) as tsb ON tsb.SecurityID1=t.SecurityID1
LEFT JOIN (
	SELECT *
FROM
(
    SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
    FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
) ths
WHERE ths.#Number=1 AND ths.TradeDate <= ?
) as tsbs ON tsbs.SecurityID1=t.SecurityID1
LEFT JOIN (
	SELECT *
FROM
(
    SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
    FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
) thsi
WHERE thsi.#Number=1 AND thsi.TradeDate <= ?
) as tsbsi ON tsbsi.SecurityID1=t.SecurityID1
INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID
where c.ContactID=? AND s.SecTypeBaseCode = ? AND s.MaturityDate >=?
GROUP BY t.SecurityID1, s.FullName,s.MaturityDate,drs.Rate,tsb.TradeDate, tsb.#Number,tsbs.TradeDate,tsbsi.TradeAmount,s.PrincipalCurrencyCode
HAVING SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) > 0 
OR SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) >0 OR 
SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) > 0
    ',[
      $this->startDate,
      $this->startDate,
      $this->endDate,
      'sl',
      $this->startDate,
      $this->endDate,
      'by',
      $this->endDate,
      'sl',
      $this->endDate,
      'by',
      $this->endDate,
      'sa',
      $this->endDate,
      $this->contact->ContactID,
      'fd',
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->startDate,
      $this->endDate,
      'sl'
    ]);


    // Sold out
    $startDate = $this->startDate;
    $endDate = $this->endDate;
    $soldout = collect($fixedDeposits)->filter(function ($fd) {
      return $fd->saleTradeDate != NULL;
    });

    $soldOutProcessed = $soldout->map(function ($fd) use ($startDate, $endDate) {
      return [
        "FullName" => $fd->FullName,
        "PrincipalCurrencyCode"=>$fd->PrincipalCurrencyCode,
        "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->startValue,
        "bought" => $fd->bought,
        "sold" => $fd->sold + ($fd->Rate / 100 / 365 *  ((new \DateTime($fd->saleTradeDate))->diff(new \DateTime($fd->firstTradeDate))->days)) * $fd->sold,
        "interest" => + ($fd->Rate / 100 / 365 *  ((new \DateTime($endDate))->diff(new \DateTime($fd->saleTradeDate))->days)) * $fd->sold,
        "endValue" => 0
      ];
    });

    // Not sold out
    $notSold = collect($fixedDeposits)->filter(function ($fd) {
      return $fd->saleTradeDate === NULL;
    });

    $notSoldProcessed = $notSold->map(function ($fd) use ($startDate, $endDate) {
      return [
        "FullName" => $fd->FullName,
        "PrincipalCurrencyCode"=>$fd->PrincipalCurrencyCode,
        "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  (new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days) * $fd->startValue,
        "bought" => $fd->bought,
        "sold" => $fd->sold,
        "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->bought,
        "endValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  (new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days) * $fd->startValue + ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->bought + $fd->startValue + $fd->bought
      ];<?php

      namespace App\Transactions;
      
      use App\Models\Contact;
      use Illuminate\Support\Facades\DB;
      
      class Transactions
      {
      
        function __construct(Contact $contact, $startDate, $endDate)
        {
          $this->contact = $contact;
          $this->startDate = $startDate;
          $this->endDate = $endDate;
        }
      
        function processTransactions($transactionCode)
        {
          return  DB::connection('sqlsrv')->select(
            'select t.SecurityID1,s.FullName,s.PrincipalCurrencyCode,ph.PriceValue as marketPrice,pph.PriceValue as unitPrice, 
                      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*pph.PriceValue ELSE 0 END) AS startValue,
                      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) AS startUnits,
      
                      SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
                      SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
                      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*ph.PriceValue ELSE 0 END) as endValue,
                      SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) as endUnits,
                      (SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*ph.PriceValue ELSE 0 END) 
                      -(SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity*pph.PriceValue ELSE 0 END)
                      -SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END)
                      +SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END))) AS interest
      
      
            from vQbRowDefContact c 
      INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
      INNER JOIN AdvApp.vPortfolioTransaction  t ON t.PortfolioID=p.PortfolioID
      INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
      INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
      
      CROSS APPLY 
      (
      SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate= ?
      ) ph
      CROSS APPLY 
      (
      SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate=?
      ) pph
      
      where c.ContactID=? AND s.SecTypeBaseCode = ? 
      GROUP BY t.SecurityID1,s.FullName, ph.PriceValue, pph.PriceValue,s.PrincipalCurrencyCode
      HAVING 
            SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) >0.5 
            OR  
            SUM(CASE WHEN t.TradeDate <= ? THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) >0.5',
            [
              $this->startDate,
              $this->startDate,
              $this->startDate,
              $this->endDate,
              "sl",
              $this->startDate,
              $this->endDate,
              "by",
              $this->endDate,
              $this->endDate,
              $this->endDate,
              $this->startDate,
              $this->startDate,
              $this->endDate,
              "sl",
              $this->startDate,
              $this->endDate,
              "by",
              $this->endDate,
              $this->startDate,
              $this->contact->ContactID,
              $transactionCode,
              $this->startDate,
              $this->endDate
            ]
          );
        }
      
        function mutualfunds()
        {
          return $this->processTransactions("mf");
        }
      
        function equities()
        {
          return $this->processTransactions("cs");
        }
      
        function fixedDeposits()
        {
          $fixedDeposits = DB::connection('sqlsrv')->select('
          select t.SecurityID1,s.FullName,s.MaturityDate,drs.Rate,s.PrincipalCurrencyCode,tsb.TradeDate saleTradeDate,tsb.#Number,tsbs.TradeDate firstTradeDate, tsbsi.TradeAmount as interest,
          SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) AS startValue,
                                                              SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
                                                              SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
                                      SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) as endValue
                                      
      from vQbRowDefContact c 
      INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
      INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
      LEFT JOIN (
          SELECT *
      FROM
      (
          SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
          FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
      ) th
      WHERE th.#Number=1 AND th.TradeDate >= ?
      ) as tsb ON tsb.SecurityID1=t.SecurityID1
      LEFT JOIN (
          SELECT *
      FROM
      (
          SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
          FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
      ) ths
      WHERE ths.#Number=1 AND ths.TradeDate <= ?
      ) as tsbs ON tsbs.SecurityID1=t.SecurityID1
      LEFT JOIN (
          SELECT *
      FROM
      (
          SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
          FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
      ) thsi
      WHERE thsi.#Number=1 AND thsi.TradeDate <= ?
      ) as tsbsi ON tsbsi.SecurityID1=t.SecurityID1
      INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
      INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
      INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
      INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID
      where c.ContactID=? AND s.SecTypeBaseCode = ? AND s.MaturityDate >=?
      GROUP BY t.SecurityID1, s.FullName,s.MaturityDate,drs.Rate,tsb.TradeDate, tsb.#Number,tsbs.TradeDate,tsbsi.TradeAmount,s.PrincipalCurrencyCode
      HAVING SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) > 0 
      OR SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount*tc.EffectOnQuantity ELSE 0 END) >0 OR 
      SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) > 0
          ',[
            $this->startDate,
            $this->startDate,
            $this->endDate,
            'sl',
            $this->startDate,
            $this->endDate,
            'by',
            $this->endDate,
            'sl',
            $this->endDate,
            'by',
            $this->endDate,
            'sa',
            $this->endDate,
            $this->contact->ContactID,
            'fd',
            $this->startDate,
            $this->endDate,
            $this->startDate,
            $this->startDate,
            $this->endDate,
            'sl'
          ]);
      
      
          // Sold out
          $startDate = $this->startDate;
          $endDate = $this->endDate;
          $soldout = collect($fixedDeposits)->filter(function ($fd) {
            return $fd->saleTradeDate != NULL;
          });
      
          $soldOutProcessed = $soldout->map(function ($fd) use ($startDate, $endDate) {
            return [
              "FullName" => $fd->FullName,
              "PrincipalCurrencyCode"=>$fd->PrincipalCurrencyCode,
              "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->startValue,
              "bought" => $fd->bought,
              "sold" => $fd->sold + ($fd->Rate / 100 / 365 *  ((new \DateTime($fd->saleTradeDate))->diff(new \DateTime($fd->firstTradeDate))->days)) * $fd->sold,
              "interest" => + ($fd->Rate / 100 / 365 *  ((new \DateTime($endDate))->diff(new \DateTime($fd->saleTradeDate))->days)) * $fd->sold,
              "endValue" => 0
            ];
          });
      
          // Not sold out
          $notSold = collect($fixedDeposits)->filter(function ($fd) {
            return $fd->saleTradeDate === NULL;
          });
      
          $notSoldProcessed = $notSold->map(function ($fd) use ($startDate, $endDate) {
            return [
              "FullName" => $fd->FullName,
              "PrincipalCurrencyCode"=>$fd->PrincipalCurrencyCode,
              "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  (new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days) * $fd->startValue,
              "bought" => $fd->bought,
              "sold" => $fd->sold,
              "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->bought,
              "endValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  (new \DateTime($startDate))->diff(new \DateTime($fd->firstTradeDate))->days) * $fd->startValue + ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($fd->firstTradeDate))->days + 1)) * $fd->bought + $fd->startValue + $fd->bought
            ];
          });
      
          $notSoldProcessed = $notSoldProcessed->merge($soldOutProcessed);
          return $notSoldProcessed->all();
        }
      
        function fixedIncome()
        {
          $fixedincome = DB::connection('sqlsrv')->select('select t.SecurityID1,s.FullName,s.MaturityDate,drs.Rate,tsb.TradeDate,
          SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount ELSE 0 END) AS startValue,
          
                                      SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
                                      SUM(CASE WHEN t.TradeDate >=? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
          
                                      SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount ELSE 0 END) as endValue
          from vQbRowDefContact c 
          INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
          INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
          LEFT JOIN (
            SELECT *
          FROM
          (
              SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
              FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
          ) th
          WHERE th.#Number=1 AND th.TradeDate <= ?
          ) as tsb ON tsb.SecurityID1=t.SecurityID1
        
          INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
          INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
          INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
          INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID 
          where c.ContactID=? AND s.SecTypeBaseCode = ? AND s.MaturityDate >=? AND drs.Rate IS NOT NULL  
          
          GROUP BY t.SecurityID1, s.FullName,s.MaturityDate,drs.Rate, tsb.TradeDate',[
            $this->startDate,
            $this->startDate,
            $this->endDate,
            'sl',
            $this->startDate,
            $this->endDate,
            'by',
            $this->endDate,
            'by',
            $this->endDate,
            $this->contact->ContactID,
            'ck',
            '2021-05-01'    
          ]);
      
      
      // Sold out
      $startDate = $this->startDate;
      $endDate = $this->endDate;
      $soldout = collect($fixedincome)->filter(function ($fd) {
        return $fd->sold > 0;
      });
      
      $soldOutProcessed = $soldout->map(function ($fd) use ($startDate, $endDate) {
        return [
          "FullName" => $fd->FullName,
          "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days + 1)) * $fd->startValue,
          "bought" => $fd->bought,
          "sold" =>$fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days + 1)) * $fd->startValue+($fd->Rate / 100 / 365 *  ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days)) * $fd->sold,
          "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days+1)) * $fd->sold,
          "endValue" => 0
        ];
      });
      // Not sold out
      $notSold = collect($fixedincome)->filter(function ($fd) {
        return $fd->sold <= 0;
      });
      
      $notSoldProcessed = $notSold->map(function ($fd) use ($startDate, $endDate) {
        return [
          "FullName" => $fd->FullName,
          "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days+1)) * $fd->startValue,
          "bought" => $fd->bought,
          "sold" => $fd->sold,
          "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days+1)) * ($fd->startValue+$fd->bought),
          "endValue" => ( $fd->startValue + ($fd->Rate / 100 / 365  * ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days+1)) * ($fd->startValue+$fd->bought) +(($fd->Rate / 100 / 365  *  ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days)) * ($fd->startValue))+$fd->bought)
        ];
      });
      
      $notSoldProcessed = $notSoldProcessed->merge($soldOutProcessed);
      return $notSoldProcessed->all();
        }
      
      
      function cashAndEquivalents(){
      
      
        return 0;
      
      }
        function latestTransactions()
        {
        }
      }
      
    });

    $notSoldProcessed = $notSoldProcessed->merge($soldOutProcessed);
    return $notSoldProcessed->all();
  }

  function fixedIncome()
  {
    $fixedincome = DB::connection('sqlsrv')->select('select t.SecurityID1,s.FullName,s.MaturityDate,drs.Rate,tsb.TradeDate,
    SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount ELSE 0 END) AS startValue,
    
                                SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as sold,
                                SUM(CASE WHEN t.TradeDate >=? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as bought,
    
                                SUM(CASE WHEN t.TradeDate <= ? THEN t.TradeAmount ELSE 0 END) as endValue
    from vQbRowDefContact c 
    INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
    INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
    LEFT JOIN (
      SELECT *
    FROM
    (
        SELECT *, ROW_NUMBER() OVER (PARTITION BY SecurityID1  ORDER BY TradeDate DESC) #Number
        FROM  AdvApp.vPortfolioTransaction WHERE TransactionCode=?
    ) th
    WHERE th.#Number=1 AND th.TradeDate <= ?
    ) as tsb ON tsb.SecurityID1=t.SecurityID1
  
    INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
    INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
    INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
    INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID 
    where c.ContactID=? AND s.SecTypeBaseCode = ? AND s.MaturityDate >=? AND drs.Rate IS NOT NULL  
    
    GROUP BY t.SecurityID1, s.FullName,s.MaturityDate,drs.Rate, tsb.TradeDate',[
      $this->startDate,
      $this->startDate,
      $this->endDate,
      'sl',
      $this->startDate,
      $this->endDate,
      'by',
      $this->endDate,
      'by',
      $this->endDate,
      $this->contact->ContactID,
      'ck',
      '2021-05-01'    
    ]);


// Sold out
$startDate = $this->startDate;
$endDate = $this->endDate;
$soldout = collect($fixedincome)->filter(function ($fd) {
  return $fd->sold > 0;
});

$soldOutProcessed = $soldout->map(function ($fd) use ($startDate, $endDate) {
  return [
    "FullName" => $fd->FullName,
    "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days + 1)) * $fd->startValue,
    "bought" => $fd->bought,
    "sold" =>$fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days + 1)) * $fd->startValue+($fd->Rate / 100 / 365 *  ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days)) * $fd->sold,
    "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days+1)) * $fd->sold,
    "endValue" => 0
  ];
});
// Not sold out
$notSold = collect($fixedincome)->filter(function ($fd) {
  return $fd->sold <= 0;
});

$notSoldProcessed = $notSold->map(function ($fd) use ($startDate, $endDate) {
  return [
    "FullName" => $fd->FullName,
    "startValue" => $fd->startValue + ($fd->Rate / 100 / 365 *  ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days+1)) * $fd->startValue,
    "bought" => $fd->bought,
    "sold" => $fd->sold,
    "interest" => ($fd->Rate / 100 / 365 * ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days+1)) * ($fd->startValue+$fd->bought),
    "endValue" => ( $fd->startValue + ($fd->Rate / 100 / 365  * ((new \DateTime($startDate))->diff(new \DateTime($fd->TradeDate))->days+1)) * ($fd->startValue+$fd->bought) +(($fd->Rate / 100 / 365  *  ((new \DateTime($endDate))->diff(new \DateTime($startDate))->days)) * ($fd->startValue))+$fd->bought)
  ];
});

$notSoldProcessed = $notSoldProcessed->merge($soldOutProcessed);
return $notSoldProcessed->all();
  }


function cashAndEquivalents(){


  return 0;

}
  function latestTransactions()
  {
  }
}
