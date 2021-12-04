<?php

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
      '
    select t.SecurityID1,s1.FullName,s1.PrincipalCurrencyCode as securityCurrency,s2.PrincipalCurrencyCode as contributionsCurrency,
				 SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) AS quantity,
				SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
					where securityid=t.SecurityID1 and PriceDate=?) as startValue,
					(select ClosePrice from AdvApp.vSecurityPrice where securityid=t.SecurityID1 and PriceDate=?)
					 as unitPrice,
					(select ClosePrice from AdvApp.vSecurityPrice
				where securityid=t.SecurityID1 and PriceDate=?) as marketPrice,
				SUM(CASE WHEN t.TradeDate >= ?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as contributions,
				SUM(CASE WHEN t.TradeDate >=?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as withdrawals,
				
        
        CASE WHEN s1.PrincipalCurrencyCode=s2.PrincipalCurrencyCode
				THEN
				SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
				where securityid=t.SecurityID1 and PriceDate=?)
				-SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
					where securityid=t.SecurityID1 and PriceDate=?)
					-SUM(CASE WHEN t.TradeDate >= ?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END)
					+SUM(CASE WHEN t.TradeDate >= ?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END)
				ELSE
				SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
					where securityid=t.SecurityID1 and PriceDate=?)
				-SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
					where securityid=t.SecurityID1 and PriceDate=?)
				END as interest,


				SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
				where securityid=t.SecurityID1 and PriceDate=?) as endValue
                  from vQbRowDefContact c 
INNER JOIN AdvApp.vPortfolio p ON c.ContactID=p.PrimaryContactID
INNER JOIN AdvApp.vPortfolioTransaction  t ON t.PortfolioID=p.PortfolioID
INNER JOIN AdvSecurity s2 ON s2.SecurityID=t.SecurityID2
INNER JOIN AdvSecurity s1 ON s1.SecurityID=t.SecurityID1
INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
where c.ContactID=? AND   s1.SecTypeBaseCode = ? 
GROUP BY t.SecurityID1,s1.FullName,s1.PrincipalCurrencyCode,s2.PrincipalCurrencyCode
HAVING SUM(CASE WHEN t.TradeDate <= ?  THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END)*(select ClosePrice from AdvApp.vSecurityPrice
				where securityid=t.SecurityID1 and PriceDate=?) > 1',
      [
        $this->endDate,
        $this->startDate,
        $this->startDate,
        $this->startDate,
        $this->endDate,
        $this->startDate,
        $this->endDate,
        'by',
        $this->startDate,
        $this->endDate,
        'sl',



        $this->endDate,
        $this->endDate,
        $this->startDate,
        $this->startDate,
        $this->startDate,
        $this->endDate,
        'by',
        $this->startDate,
        $this->endDate,
        'sl',

        $this->endDate,
        $this->endDate,
        $this->endDate,
        $this->startDate,



        $this->endDate,
        $this->endDate,
        $this->contact->ContactID,
        $transactionCode,
        $this->endDate,
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
    $fixedDeposits = DB::connection('sqlsrv')->select('select s.SecurityID,s.FullName, t.TradeAmount, drs.Rate,t.TradeDate,s.MaturityDate,t.TradeDate,s.PrincipalCurrencyCode as securityCurrency,
    CASE WHEN t.TradeDate <? 
       THEN 
        ((DATEDIFF(day,t.TradeDate,?)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount
       ELSE 
        0 END startValue,
        CASE WHEN t.TradeDate >? AND t.TradeDate <? 
			THEN t.TradeAmount
		ELSE 0 END contributions,
    SUM(CASE WHEN t.TradeDate >= ?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as withdrawals,

       CASE WHEN t.TradeDate > ?
       THEN ((DATEDIFF(day,t.TradeDate,?)*(drs.Rate/36500)*t.TradeAmount)*0.85)  ELSE ((DATEDIFF(day,?,?)*(drs.Rate/36500)*t.TradeAmount)*0.85) END AS interest,
        CASE WHEN t.TradeDate > ?
       THEN ((DATEDIFF(day,t.TradeDate,?)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount  ELSE ((DATEDIFF(day,?,?)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount END AS endValue
      from vQbRowDefContact c 
      INNER JOIN AdvApp.vPortfolio p ON c.ContactID=p.PrimaryContactID
      INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
      INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
      INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
      INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
      INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID 
      where c.ContactID=? AND s.SecTypeBaseCode = ? AND drs.Rate IS NOT NULL AND s.MaturityDate > ? AND t.TransactionCode=? AND t.TradeDate < ?
    group by  s.SecurityID,s.FullName, t.TradeAmount, drs.Rate,t.TradeDate,s.MaturityDate,s.PrincipalCurrencyCode,tc.TransactionCode,t.TradeDate', [
      $this->startDate,
      $this->startDate,
      $this->startDate,
      $this->endDate,
      // New
      $this->startDate,
      $this->endDate,
      'sl',
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->endDate,
      $this->contact->ContactID,
      'fd',
      $this->endDate,
      'by',
      $this->endDate

    ]);

    return $fixedDeposits;
  }

  function fixedIncome()
  {
    $fixedincome = DB::connection('sqlsrv')->select('select s.SecurityID,s.FullName, t.TradeAmount, drs.Rate,t.TradeDate,s.MaturityDate,t.TradeDate,s.PrincipalCurrencyCode as securityCurrency,
    CASE WHEN t.TradeDate <? 
       THEN 
        ((((DATEDIFF(day,t.TradeDate,?))+1)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount
       ELSE 
        0 END startValue,
        CASE WHEN t.TradeDate >? AND t.TradeDate <? 
			THEN t.TradeAmount
		ELSE 0 END contributions,
    SUM(CASE WHEN t.TradeDate >= ?  AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as withdrawals,
       CASE WHEN t.TradeDate > ?
       THEN ((((DATEDIFF(day,t.TradeDate,?))+1)*(drs.Rate/36500)*t.TradeAmount)*0.85)  ELSE ((((DATEDIFF(day,?,?))+1)*(drs.Rate/36500)*t.TradeAmount)*0.85) END AS interest,
       CASE WHEN s.MaturityDate > ?
       THEN ((((DATEDIFF(day,t.TradeDate,?))+1)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount 
        ELSE ((DATEDIFF(day,t.TradeDate,s.MaturityDate)*(drs.Rate/36500)*t.TradeAmount)*0.85)+t.TradeAmount 
          END AS endValue
      from vQbRowDefContact c 
      INNER JOIN AdvApp.vPortfolio p ON c.ContactID=p.PrimaryContactID
      INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
      INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
      INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
      INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
      INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID 
      where c.ContactID=? AND s.SecTypeBaseCode = ? AND drs.Rate IS NOT NULL AND s.MaturityDate > ? AND t.TransactionCode=? AND t.TradeDate < ?
    group by  s.SecurityID,s.FullName, t.TradeAmount, drs.Rate,t.TradeDate,s.MaturityDate,s.PrincipalCurrencyCode,tc.TransactionCode,t.TradeDate', [
      $this->startDate,
      $this->startDate,
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->endDate,
      'sl',
      $this->startDate,
      $this->endDate,
      $this->startDate,
      $this->endDate,

      $this->endDate,
      $this->endDate,
      // $this->startDate,
      // $this->endDate,
      // $this->startDate,
      // $this->endDate,
      $this->contact->ContactID,
      'ck',
      $this->endDate,
      'by',
      $this->endDate
    ]);
    return $fixedincome;
  }


  function cashAndEquivalents()
  {


    return 0;
  }
  function latestTransactions()
  {

    $transactions = DB::connection('sqlsrv')->select('
    select  REPLACE (REPLACE (REPLACE(tc.TranCodeLabel, ?, ?), ?, ?), ?, ?) TransactionLabel,s1.FullName,t.TradeDate, t.Quantity, t.TradeAmount
    from vQbRowDefContact c 
          INNER JOIN AdvApp.vPortfolio p ON c.ContactID=p.PrimaryContactID
          INNER JOIN AdvApp.vPortfolioTransaction  t ON t.PortfolioID=p.PortfolioID

          INNER JOIN AdvSecurity s1 ON s1.SecurityID=t.SecurityID1
          INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode

          where c.ContactID=?  AND t.TradeDate >=? AND t.TradeDate <=? AND tc.IsAllowedInTransaction=1
', [
      'Deliver In (Long)', 'Contributions',
      'Deliver Out (Long)', 'Withdrawals',
      '', '',
      $this->contact->ContactID,
      $this->startDate,
      $this->endDate
    ]);
    return $transactions;
  }

  function summary(){
    $transactions=new Transactions($this->contact,$this->startDate,$this->endDate);
    $mutualFunds=$transactions->mutualfunds();
    $equities=$transactions->equities();
    $fixedDeposits=$transactions->fixedDeposits();
    $fixedIncome=$transactions->fixedIncome();
    $latestTransactions=$transactions->latestTransactions();

    // Summary By DefaultInKES

    // Can be in KES or USD as declared by the user
    $startValue=0;
    $startValueUSD=0;
    $contributions=0;
    $contributionsUSD=0;
    $withdrawals=0;
    $withdrawalsUSD=0;
    $interest=0;
    $interestUSD=0;
    $endValue=0;
    $endValueUSD=0;


    // Combine All funds array
    $allfunds=array_merge($mutualFunds,$equities,$fixedDeposits,$fixedIncome);


    if ($this->contact->currency()->count() > 0) {
      $currency = $this->contact->currency->currency;
  } else {
      $currency = "";
  }

  if($currency==="usd"){

//Convert to USD all KES and retain USD
foreach($allfunds as $fund){
  // StartValue
  if($fund->securityCurrency==="us"){
      $startValueUSD+=$fund->startValue;
  } elseif($fund->securityCurrency==="ke"){
    $startValueUSD+=($fund->startValue)*currency_rate($this->startDate,$fund->securityCurrency,"us");
  }

  // Contributions
  if($fund->securityCurrency==="ke"){
      $contributionsUSD+=$fund->contributions*currency_rate($this->startDate,$fund->securityCurrency,"us");
  } elseif($fund->contributionsCurrency==="us"){
    $contributionsUSD+=$fund->contributions;
  }

  // Withdrawals
  if($fund->securityCurrency==="ke"){
      $withdrawalsUSD+=$fund->withdrawals*currency_rate($this->startDate,$fund->securityCurrency,"us");
  } elseif($fund->securityCurrency==="us"){
     $withdrawalsUSD+=$fund->withdrawals;
  } 

  // interests
  if($fund->securityCurrency==="ke"){
      $interestUSD+=$fund->interest*currency_rate($this->startDate,$fund->securityCurrency,"us");
  } elseif($fund->securityCurrency==="us"){
    $interestUSD+=$fund->interest;
  } 

  // EndValue
  if($fund->securityCurrency==="ke"){
      $endValueUSD+=$fund->endValue*currency_rate($this->startDate,$fund->securityCurrency,"us");
  } elseif($fund->securityCurrency==="us"){
    $endValueUSD+=$fund->endValue;
  } 

}

  } elseif($currency==="kes"){
// Default in KES 
foreach($allfunds as $fund){
  // StartValue
  if($fund->securityCurrency==="ke"){
      $startValue+=$fund->startValue;
  } elseif($fund->securityCurrency==="us"){
    $startValue+=($fund->startValue)*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  } 

  // Contributions
  if($fund->securityCurrency==="ke"){
      $contributions+=$fund->contributions;
  } elseif($fund->contributionsCurrency==="us"){
    $contributions+=$fund->contributions*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  }

  // Withdrawals
  if($fund->securityCurrency==="ke"){
      $withdrawals+=$fund->withdrawals;
  } elseif($fund->securityCurrency==="us"){
     $withdrawals+=$fund->withdrawals*currency_rate($this->startDate,$fund->securityCurrency,"ke");
    
  } 

  // interests
  if($fund->securityCurrency==="ke"){
      $interest+=$fund->interest;
  } elseif($fund->securityCurrency==="us"){
    $interest+=$fund->interest*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  } 

  // EndValue
  if($fund->securityCurrency==="ke"){
      $endValue+=$fund->endValue;
  } elseif($fund->securityCurrency==="us"){
    $endValue+=($fund->endValue)*currency_rate($this->startDate,$fund->securityCurrency,"ke");

  } 

}
  }
 else{
// Default in KES and USD Separated
foreach($allfunds as $fund){
  // StartValue
  if($fund->securityCurrency==="ke"){
      $startValue+=$fund->startValue;
  } elseif($fund->securityCurrency==="us"){
    $startValueUSD+=$fund->startValue;
  } else{
      $startValue+=($fund->startValue)*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  }

  // Contributions
  if($fund->securityCurrency==="ke"){
      $contributions+=$fund->contributions;
  } elseif($fund->contributionsCurrency==="us"){
    $contributionsUSD+=$fund->contributions;
  }

  // Withdrawals
  if($fund->securityCurrency==="ke"){
      $withdrawals+=$fund->withdrawals;
  } elseif($fund->securityCurrency==="us"){
     $withdrawalsUSD+=$fund->withdrawals/currency_rate($this->startDate,$fund->securityCurrency,"ke");
  } 

  // interests
  if($fund->securityCurrency==="ke"){
      $interest+=$fund->interest;
  } elseif($fund->securityCurrency==="us"){
    $interestUSD+=$fund->interest;
  } else{
      $interest+=($fund->interest)*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  }

  // EndValue
  if($fund->securityCurrency==="ke"){
      $endValue+=$fund->endValue;
  } elseif($fund->securityCurrency==="us"){
    $endValueUSD+=$fund->endValue;
  } else{
      $endValue+=($fund->endValue)*currency_rate($this->startDate,$fund->securityCurrency,"ke");
  }

}
  }




    $summary=[
        "startValue"=>$startValue,
        "startValueUSD"=>$startValueUSD,

        "contributions"=>$contributions,
        "contributionsUSD"=>$contributionsUSD,

        "withdrawals"=>$withdrawals,
        "withdrawalsUSD"=>$withdrawalsUSD,

        "interest"=>$interest,
        "interestUSD"=>$interestUSD,

        "endValue"=>$endValue,
        "endValueUSD"=>$endValueUSD

    ];

    return $summary;
  }
}
