
##Meeting 15/01/2020

Meeting Updates

  // $startDate=Carbon::now()->subMonth()->endOfMonth()->toDateString();
        // $endDate=Carbon::yesterday()->toDateString();


----SMS Notification (AGM, New Product Notification, )
----Maureen Tele Account


Next Week
Tests (Scheduling)


Passwords as per user requests








##Report
Name of the Portfolio
Client NO
Contributions
Withdrawals
Accrued Interest


Porfolio Holdings


### Database APXFirm
AdvPortfolio    
    - Lists all portfolios
AdvPorfolio_Audit
    - Porfolio Status

vQbRowDefContact
            - ContactID *
            - ContactName
            - FirstName
            - MiddleName
            - Prefix
            - Suffix
            - Company
            - Email
            - Email2
            - Email3
            - AuditEventID
            - AuditEventID
            - DeliveryName
            - IsDeliveryNameEdited
            - BusinessPhone
            - BusinessPhoneID
            - Birthdate
            - TaxNumber
            - OwnerName
            - Status
            - QuickInfo (HTML)
            - Salutation
            - Gender
            - Occupation
            - Notes
            - RetirementDate
            - RetirementDate
            - TaxBracket
            - IsIRA
            - IsLifeInsurance
            - IsTrustFund
            - IsRetired
            - IsReferralRequest
            - ContactCode *
            - ContactGUID
            - EmailForCommunication
            - ClassID
            - IsPerson
            - ContactGroupType
            - BankDetails
            - NationalID
            - MarketSegmentation
    
AdvPortfolioTransaction (PortfolioTransaction)

 PortfolioID: "203",
     PortfolioTransactionID: "3",
     TradeDate: "2013-09-24",
     SequenceNo: "32768",
     RecID: "20",
     TransactionCode: "li",
     Comment: "",
     SecTypeCode1: "ca",
     SecurityID1: "177",
     SettleDate: null,
     OriginalCostDate: null,
     Quantity: null,
     QuantityPrec: "0",
     ClosingMethodCode: " ",
     SecTypeCode2: null,
     SecurityID2: null,
     NumeratorCurrCode: null,
     DenominatorCurrCode: null,
     TradeDateFX: null,
     TradeDateFXPrec: "0",
     SettleDateFX: null,
     SettleDateFXPrec: "0",
     OriginalFX: null,
     OriginalFXPrec: "0",
     MarkToMarket: "1",
     TradeAmount: "5000000.0",
     TradeAmountPrec: "0",
     OriginalCost: null,
     OriginalCostPrec: "0",
     WithholdingTax: null,
     WithholdingTaxPrec: "0",
     ExchangeID: "0",
     ExchangeFee: null,
     ExchangeFeePrec: "0",
     Commission: null,
     CommissionPrec: "0",
     ImpliedCommission: "0",
     OtherFees: null,
     OtherFeesPrec: "0",
     FeePeriodDate: null,
     CommissionPurposeID: "0",
     Pledge: "0",
     CustodianID: "0",
     DestPledge: "0",
     DestCustodianID: "0",
     OriginalFace: null,
     OriginalFacePrec: "0",
     YieldOnCost: null,
     YieldOnCostPrec: "0",
     DurationOnCost: null,
     DurationOnCostPrec: "0",
     TransUserDef1ID: "0",
     TransUserDef2ID: "0",
     TransUserDef3ID: "0",
     TranID: "100",
     IPCounter: "-3",
     SourceID: "2",
     PostDate: "2013-11-21",
     LotNumber: "-3",
     ReclaimAmount: null,
     ReclaimAmountPrec: "0",
     StrategyID: "0",
     RecordDate: null,
     DivTradeDate: null,
     PerfContributionOrWithdrawal: null,
     VersusDate: null,
     BrokerFirmID: null,
     BrokerRepSecurityID: null,
     TradeBlotterLineID: null,
     OmnibusID: null,
     ApplyToShortPosition: "0",
     EstDividendState: "0",
     AllocationID: null,
     IsRecallable: null,
     ContributedCapital: null,
     ContributedCapitalPrec: null,
     CommittedCapital: null,
     CommittedCapitalPrec: null,
     AuditEventID: "440",
     AuditTypeCode: "I",
     AuditTimestamp: b"\0\0\0\0\0nÇ8",
     CostAdjustmentTypeCode: null,
     FlowTimingCode: null,
     SettledByDate: null,
     AdjustedCost: null,
     AdjustedCostPrec: null,
     TransUserDef4ID: "0",
     TransUserDef5ID: "0",
     TransUserDef6ID: "0",
     TransUserDef7ID: "0",
     TransUserDef8ID: "0",
     TransUserDef9ID: "0",
     MiscFees: null,
     MiscFeesPrec: "0",
            - PortfolioID
            - PortfolioTransactionID
            - TradeDate
            - SequenceNo
            - SecurityID1* Security
            - SettleDate
            - OriginalCostDate
            - Quantity
            - TransactionCode
            - SecTypeCode2
            - SecurityID2
            - MarkToMarket
            - TradeAmount
            - PortfolioCode*
            - ReportHeading1
            - StartDate
            - CustodianID
            - InitialValue
            - CloseDate
            - PortfolioTypeCode
            - TradeAmountPrec
            - TotalMarketValue
            - TotalCash
            - DestCustodianID
            - PortfolioGUID
            - PrimaryContactID *
            - PrimaryContactCode * 
            - PrimaryContactName
            - PrimaryContactEmail1
            - TotalMarketValueInGlobalCurrency
            - TotalCashInGlobalCurrency
            - HoldingsStatus
            - TotalAccruedInterest
            - TotalMarketValueWithAccruedInterest
            - IsPortfolioStatusOpen

vQbRowDefPortfolio (Portfolio)
            - PortfolioID
            - PortfolioCode
            - ShortName
            - ReportHeading1
            - InitialValue
            - InvestmentGoal
            - OwnerID
            - PortfolioStatus
            - TotalTradableCash
            - PortfolioBaseCurrencyISOCode ['KES','USD']
            - PortfolioTypeCode (Joint)
            - DefaultSettlementCurrencyCode
            - BaseCurrencyCode
            - LastHoldingsUpdate
            - TotalMarketValue*
            - TotalMarketValueInGlobalCurrency
            - LastHoldingsUpdate (DateTime)*
            - TotalCash
            - PriceSetID
            - PortfolioGUID
            - PrimaryContactID *

            - StartDate
            - CashSecurityID *
            - CloseDate
            - AccruedInterestID
            - CustodianID
            - OwnerContactCode *
            - OwnerContactID *
            - TotalAccruedInterest
AdvPortfolio 
            - PortfolioID
            - ProcessingGroupID
            - IsIncomplete
            - AuditEventID
            - AuditTypeCode
            - AuditTimestamp
vAxPortfolio *
            
AdvHoldingHistory (PortfolioHoldingHistory)
            - PorfolioID
            - SecurityID
            - HeldFromDate
            - heldThruDate
            -LatestSettleDate
AdvPortfolioBase
            - PortfolioBaseID
            - ClassID
            - StartDate
            - CloseDate
            - NumOfCopies
AdvPortfolioBase_Audit
            - PortfolioBaseID
            - ClassID
            - StartDate
            - CloseDate
AdvPosition 
            - PositionID
            - PortfolioID
            - SecurityID
            - SecTypeCode
            - SettleDate
            - Quantity
vAHAdvSecurity
            - SecurityID
            - SecTypeBaseCode
            - PrincipalCurrencyCode
            - ExchangeID
            - SecurityGUID
            - SymbolValidThruDate
            - SymbolValidFromDate
            - ProprietarySymbol
            - FullName
            - InterestRate
            - NextPaymentDate
            - MaturityDate
            - Symbol
vAHFAdvSecurity 
             - SecurityID
             - SecTypeBaseCode
             - PrincipalCurrencyCode
             - ExchangeID
             - SecurityGUID
             - SymbolValidFromDate
             - SymbolValidThruDate
             - ProprietarySymbol
             - FullName
             - UnderlyingSecurityID
             - InterestRate
             - NextPaymentDate
             - CurrentAuditEventID
AdvCustodian 
             - CustodianID
             - CustodianName
             - IsSystem
             - DTCNumber
             - BIC
             - ClearingCustID
             - SubCustID
             - AuditEventID
             - AuditTypeCode
             - AuditTimestamp
AdvPortfolioGroup
             - PortfolioGroupID
             - Purpose
             - IsPortfolioSorted
             - GroupRuleID
             - AuditEventID
             - AuditTimestamp
             - AccountStatus
             - InvestmentGoal
             - GroupTypeCode 
AdvSecurity
             - SecurityID
             - SecTypeBaseCode
             - PrincipalCurrencyCode
             - SecurityGUID
             - SymbolValidThruDate
             - SymbolValidFromDate
             - Symbol
             - ProprietarySymbol
             - FullName
             - MaturityDate
vQbRowDefSecurity
             - SecurityID
             - SecTypeBaseCode
             - PrincipalCurrencyCode
             - ExchangeID
             - SymbolValidThruDate
             - SymbolValidFromDate
             - SymbolTypeCode
             - CUSIP
             - FullName
             - UnderlyingSecurityID
             - InterestOrDividendRate
             - NextPaymentDate
             - PaymentFrequencyID
             - ShortAssetClassCode
             - RiskCountryCode
             - IndustryGroupCode
             - IndustryGroupName
             - SectorName
             - CouponAccrualHolidayRuleCode
vAHFAdvSecurity
            - SecurityID
            - SecTypeBaseCode
            - PrincipalCurrencyCode
            - ExchangeID
            - SecurityGUID
            - SymbolValidFromDate
            - SymbolValidThruDate
            - FullName
            - UnderlyingSecurityID
            - InterestRate
            - NextPaymentDate
            - MaturityDate
            - PaymentFrequencyID
            - RiskCountryCode
            - IssueCountryCode
            - StrategyID
            - StateCode
            - ValuationFactor
            - ValuationFactor
            - IsTradingCash
            - EPSAnnual
            - SharesOutstanding
AdvPriceHistory
            - FromDate
            - PriceTypeID
            - SecurityID *
            - SourceIDFrom
            - ThruDate
            - PriceValue
            - AuditTimestamp


Transcode - li (CashIN)


Porfolio Value 

        Date (Last Date of Previous Month)
        Total Of TradeAmount to the lastDate of Last Month

        Difference (Contributions)
        Date (Today); Total Trade Amount

by - Quantity 
   - TradeAmount
   - Source Type

Sum All Quantity + TradeAmount 
        Market Value = Sum * Today Price    

SecurityType: Mutual Funds KE (MF000010)
SecTypeBaseName

Settle Date : Same date as Trade Date
Quantity: Units (TradeAmount/PriceValueOf Trade Date)


vAH




mfke
MF000010
Western KES Money Market Fund

mfke
MF000011
Western KES Fixed Income Fund

mfus
MF000002
Western Africa Money Market Fund

mfus
MF000003
Western Africa Balanced Fund

mfus
MF000004
Western Africa Equity Fund

mfus
MF000005
Western Africa Fixed Income Fund




AdvTransactionCode 
   -TransactionCode
   -TranCodeLabel
   -EffectOnQuantity
    0 1 -1

    si - Deliver IN (1)
    sl - Sell (-1)
    to - transfer out (-1)
    so
    ss
    ti
    wd


    pv- Prior Value


PortfolioGroupID
    -PortfolioGroupID
    -Purpose
    
        - All Mutual Funds Clients
        - Private Wealth Clients
        - Clients Under Asset Management
        - Clients Under Asset Management
    

    CurrencyRates
    vAdvFxRateLatest
        -AsOfDate Yesterday
        -NumeratorCurrCode
        -DenominatorCurrCode
        -SpotRate  


    AdvDateRateSchedule
        -DateRateID
        -AsOfDate
        -Rate

    AdvDateRate 
        - DateRateID
        - ClassID
        - DateRateName
        - DateRateTypeID
    AdvDateRateType
        -DateRateTypeID
        -DateRateTypeName
        -DateRateClassID
    AdvFixedIncome
        -SecurityID
        
    AdvFixedIncomeType
        -FixedIncomeTypeCode
        -FixedIncomeTypeName
        -TargetClassID
    
    Adv

    


       $mutualFunds=DB::connection('sqlsrv')->table('AdvPortfolioTransaction')
                                        ->join('vQbRowDefPortfolio', 'vQbRowDefPortfolio.PortfolioID', '=', 'AdvPortfolioTransaction.PortfolioID')
                                        ->join('vQbRowDefContact', 'vQbRowDefContact.ContactID', '=', 'vQbRowDefPortfolio.PrimaryContactID')
                                        ->join('AdvSecurity', 'AdvSecurity.SecurityID', '=', 'AdvPortfolioTransaction.SecurityID1')
                                        ->join('vQbRowDefSecurityType', 'AdvSecurity.SecTypeBaseCode', '=', 'vQbRowDefSecurityType.SecTypeBaseCode')
                                        ->join('AdvTransactionCode', 'AdvTransactionCode.TransactionCode', '=', 'AdvPortfolioTransaction.TransactionCode')
                                        // Price
                                        ->join('AdvPriceHistory', 'AdvPriceHistory.SecurityID', '=', 'AdvSecurity.SecurityID')
                                        ->where("vQbRowDefContact.ContactID",2593)
                                        ->where("AdvSecurity.SecTypeBaseCode","mf")
                                        ->select('AdvPortfolioTransaction.SecTypeCode1','AdvPortfolioTransaction.SecurityID1','AdvSecurity.FullName',
                                                    DB::raw('SUM(AdvPortfolioTransaction.TradeAmount) as TradeAmount'),
                                                    DB::raw('SUM(AdvPortfolioTransaction.Quantity*AdvTransactionCode.EffectOnQuantity) as Quantity'),'vQbRowDefSecurityType.SecTypeBaseName')-202,460,225.00

                                                    // DB::raw('SUM(AdvPortfolioTransaction.Quantity*AdvTransactionCode.EffectOnQuantity*AdvPriceHistory.PriceValue) as starValue'),)
                                        ->groupBy('AdvPortfolioTransaction.SecurityID1','AdvPortfolioTransaction.SecTypeCode1','AdvSecurity.FullName','vQbRowDefSecurityType.SecTypeBaseName')
                                        ->get();
                                        dd($mutualFunds);

        














<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactPasswordController;
use App\Http\Controllers\ContactScheduleController;
use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailActivityController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StatementTemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactCurrencyController;
use App\Http\Controllers\PortfolioTestController;
use App\Transactions\ClientTransactions;
use Illuminate\Support\Facades\Route;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/test', function(){

    $startDate = date('Y-m-t', strtotime('-2 months'));
    $endDate = date('Y-m-t', strtotime('-1 months'));


// $transactions=DB::connection('sqlsrv')->
// select('select t.SecTypeCode1,t.SecurityID1, SUM(t.TradeAmount*tc.EffectOnQuantity) AS TotalQuantity from vQbRowDefContact c 
// INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
// INNER JOIN AdvPortfolioTransaction t ON t.PortfolioID=p.PortfolioID
// INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
// INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
// where c.ContactID=2620
// GROUP BY t.SecTypeCode1,t.SecurityID1
// ');
// dd($transactions);
$contact=Contact::find(2593);
$transactions=$contact->transactions;

if ($contact->currency()->count() > 0) {
    $currency = $contact->currency->currency;
} else {
    $currency = "";
}



if(!empty($transactions->firstWhere("TransactionCode","by")->security)){
    $startPrice=$transactions->firstWhere("TransactionCode","by")->security->price($startDate);
    $endPrice=$transactions->firstWhere("TransactionCode","by")->security->price($endDate);
}

$mutualFunds=[];
foreach($transactions as $transaction){
    $contributions = 0;
    $bcontributions = 0;

    $withdrawals = 0;
    $tcontributions = 0;
    $twithdrawals = 0;
    $startValue = 0;
    $endValue = 0;
    $totalUnits = 0;
    $marketValue=0;
    if($transaction->SecTypeCode1==="mf"){
    
        if ($transaction->TransactionCode === "by" && $transaction->TradeDate <= $startDate) {  //Buying Units ++++
    
            if ($currency === "usd") {
                if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, Maintain
                    $startValue += $transaction->Quantity * ($startPrice);
                } elseif($transaction->security->PrincipalCurrencyCode === "ke") {
                    $startValue += $transaction->Quantity * ($startPrice/currency_rate());
                } else{
                    $startValue += $transaction->Quantity * $startPrice;
                }
            } elseif ($currency === "kes") {
                if ($transaction->security->PrincipalCurrencyCode === "ke") {  //if the security is in KES, maintain
                    $startValue += $transaction->Quantity * $startPrice;
                } elseif($transaction->security->PrincipalCurrencyCode === "us") {
                    $startValue += ($transaction->Quantity * $startPrice)*currency_rate() ;
                } else{
                    $startValue += $transaction->Quantity * $startPrice;
                }
            } else {
                $startValue += $transaction->Quantity * ($startPrice);
            }
        } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $startDate) {
            if ($currency === "usd") {
                if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                    $startValue -= $transaction->Quantity * ($startPrice);
                } elseif($transaction->security->PrincipalCurrencyCode === "ke") {
                    $startValue -= $transaction->Quantity * ($startPrice/currency_rate());
                } else {
                    $startValue -= $transaction->Quantity * $startPrice;
                }
            } elseif ($currency === "kes") {
                if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                    $startValue -= $transaction->Quantity * (currency_rate() * $startPrice);
                }elseif($transaction->security->PrincipalCurrencyCode === "ke"){
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
                } elseif($transaction->security->PrincipalCurrencyCode === "ke") {
                    $endValue += $transaction->Quantity * ($endPrice/currency_rate());
                } else{
                    $endValue += $transaction->Quantity * $endPrice;
                }
            } elseif ($currency === "kes") {
                if ($transaction->security->PrincipalCurrencyCode === "ke") {  //if the security is in KES, maintain
                    $endValue += $transaction->Quantity * $endPrice;
                } elseif($transaction->security->PrincipalCurrencyCode === "us") {
                    $endValue += $transaction->Quantity * ($endPrice*currency_rate()) ;
                } else{
                    $endValue += $transaction->Quantity * $endPrice;
                }
            } else {
                
                $endValue += $transaction->Quantity * ($endPrice);
            }
        } elseif ($transaction->TransactionCode === "sl" && $transaction->TradeDate <= $endDate) {
            if ($currency === "usd") {
                if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                    $endValue -= $transaction->Quantity * ($endPrice);
                } elseif($transaction->security->PrincipalCurrencyCode === "ke"){
                    $endValue -= $transaction->Quantity * ($endPrice/currency_rate());
                }
                 else {
                    $endValue -= $transaction->Quantity * ($endPrice);
                }
            } elseif ($currency === "kes") {
                if ($transaction->security->PrincipalCurrencyCode === "us") {  //if the security is in USD, remain
                    $endValue -= $transaction->Quantity * (currency_rate() * $endPrice);
                } 
                elseif($transaction->security->PrincipalCurrencyCode === "ke"){
                    $endValue -= $transaction->Quantity * ($endPrice);
                }
                else {
                    $endValue -= $transaction->Quantity * ($endPrice);
                }
            } else {
                $endValue -= $transaction->Quantity * ($endPrice);
            }
        }
        // Market Value
        $marketValue=$totalUnits*$endPrice;

            $mutualFunds[]=[
                "Name"=>$transaction->security->FullName,
                "Quantity"=>$transaction->Quantity*$transaction->transaction->EffectOnQuantity,
                "TradeDate"=>$transaction->TradeDate,
                "TransactionCode"=>$transaction->TransactionCode,
                "TradeAmount"=>$transaction->TradeAmount,
                "SecurityType"=>$transaction->securityType->SecTypeBaseName,
                "UnitCost"=>$transaction->security->price($startDate),
                "MarketPrice"=>$transaction->security->price($endDate)               
            ];
        

    
      
    }
}

$gs=collect($mutualFunds)->groupBy("Name");
$gs->toArray();

$groups=new Collection;
foreach($gs as $key=>$g){
    $groups->push([
        "Name"=>$key,
        "Units"=>$g->sum("Quantity"),
        "TotalCost"=>$g[0]["UnitCost"]*$g->sum("Quantity"),
        "MarketPrice"=>$g[0]["MarketPrice"]*$g->sum("Quantity"),
        "Interest"=>($g[0]["MarketPrice"]*$g->sum("Quantity"))-($g[0]["UnitCost"]*$g->sum("Quantity"))
    ]);
}

dd($groups);

// dd(collect($mutualFunds))->groupBy("Name")->all();



    // $transactions=DB::connection('sqlsrv')->table('vQbRowDefContact')
    //                                         ->where('ContactID','2620')
    //                                         ->join('vQbRowDefPortfolio','vQbRowDefContact.ContactID','=','vQbRowDefPortfolio.PrimaryContactID')
    //                                         ->join('AdvPortfolioTransaction','vQbRowDefPortfolio.PortfolioID','=','AdvPortfolioTransaction.PortfolioID')
    //                                         ->join('AdvSecurity','AdvPortfolioTransaction.SecurityID1','=','AdvSecurity.SecurityID')
    //                                         ->select('vQbRowDefPortfolio.*',DB::raw('count(*) as portfolio_count, status'))
    //                                         ->groupBy('vQbRowDefPortfolio.PortfolioID')
    //                                        ->get();    
});

// Test

Route::get('/test/contacts/portfolio/{portfolio}', [PortfolioTestController::class, 'portfolio']);
Route::get('/test/contacts/{portfolio}/download', [PortfolioTestController::class, 'downloadPDF']);
Route::post('/test/contacts/{portfolio}/send', [PortfolioTestController::class, 'sendStatement']);

Route::get('/test/contacts/consolidated/{contact}', [PortfolioTestController::class, 'consolidated']);
Route::get('/test/contacts/consolidated/{contact}/download', [PortfolioTestController::class, 'downloadPDF']);
Route::post('/test/contacts/consolidated/{contact}/send', [PortfolioTestController::class, 'sendStatement']);


// Contacts
Route::resource('contacts', ContactController::class);

// Portfolio
Route::get('/contacts/portfolio/{portfolio}', [ContactController::class, 'portfolio'])->name('contacts.portfolio');
Route::get('/contacts/{portfolio}/download', [ContactController::class, 'downloadPDF'])->name('contacts.portfolio.download');
Route::post('/contacts/{portfolio}/send', [ContactController::class, 'sendStatement'])->name('contacts.portfolio.send');

// Consolidated
Route::get('/contacts/consolidated/{contact}', [ContactController::class, 'consolidated'])->name('contacts.consolidated');
Route::get('/contacts/consolidated/{contact}/download', [ContactController::class, 'downloadConsolidatedPDF'])->name('contacts.consolidated.download');
Route::post('/contacts/consolidated/{contact}/send', [ContactController::class, 'sendConsolidated'])->name('contacts.consolidated.send');


// Clients
Route::resource('client', ClientController::class);

// Users
Route::resource('user', UserController::class);


// Schedules
Route::post('/schedule/{schedule}/addcontacts/save', [ScheduleController::class, 'addcontacts'])->name('schedule.addcontacts.save');
Route::get('/schedule/{schedule}/addcontacts', [ScheduleController::class, 'add_contacts'])->name('schedule.addcontacts');
Route::post('/schedule/{schedule}/reject', [ScheduleController::class, 'reject'])->name('schedule.reject');
Route::post('/schedule/{schedule}/approve', [ScheduleController::class, 'approve'])->name('schedule.aprove');
Route::get('/schedule/{schedule}/duplicate', [ScheduleController::class, 'duplicates'])->name('schedule.duplicates');
Route::get('/schedule/pending', [ScheduleController::class, 'pending'])->name('schedule.pending');
Route::get('/schedule/{schedule}/approve', [ScheduleController::class, 'approve'])->name('schedule.approve');
Route::get('schedule/upcoming', [ScheduleController::class, 'upcoming'])->name('schedule.upcoming');
Route::get('/schedule/{schedule}/summary', [ScheduleController::class, 'summary'])->name('schedule.summary');
Route::get('/schedule/contact/missing', [ScheduleController::class, 'withoutschedules'])->name('schedule.missing.contacts');
Route::post('/schedule/{schedule}/delete', [ScheduleController::class, 'delete'])->name('schedule.delete');
Route::get('/schedule/{schedule}/sent',[ScheduleController::class,'sentEmails'])->name('schedule.sent');
Route::get('/schedule/{schedule}/failed',[ScheduleController::class,'failedEmails'])->name('schedule.failed');

Route::resource('schedule', ScheduleController::class);

// ContactSchedules
Route::delete('contactschedules/{contactSchedule}', [ContactScheduleController::class, 'destroy'])->name('contactschedules.destroy');
Route::get('/statement/pdf-view', [StatementTemplateController::class, 'statement']);
Route::get('statements/pdf', [StatementTemplateController::class, 'pdf'])->name('statement-pdf');
Route::resource('statements', StatementTemplateController::class);

// Emails
Route::get('/emails', [EmailActivityController::class, 'index'])->name('emails.all');
Route::get('/emails/thismonth', [EmailActivityController::class, 'thismonth'])->name('emails.thismonth');
Route::get('/emails/failed', [EmailActivityController::class, 'failed'])->name('emails.failed');
Route::get('/emails/failed/thismonth', [EmailActivityController::class, 'failedthismonth'])->name('emails.failed.thismonth');

// Dashboard
Route::get('/dashboard', DashboardController::class)->name('dashboard');


// Contacts passwords
Route::get('contact-password/{contact}/password', [ContactPasswordController::class, 'create'])->name('contact-password.create.password');
Route::post('contact-password/{contact}/password', [ContactPasswordController::class, 'store'])->name('contact-password.create.password.save');
Route::post('/contact/{contact}/password/send', [ContactPasswordController::class, 'send'])->name('contact.password.send');
Route::get('contacts/missing/passwords', [ContactPasswordController::class, 'missing'])->name('contacts.missing.password');
Route::get('contacts/missing/passwords/send', [ContactPasswordController::class, 'sendMissing'])->name('contacts.missing.password.send');
Route::post('contacts/{contact}/passwords/delete', [ContactPasswordController::class, 'deletepassword'])->name('contacts.password.delete');


Route::resource('contact-password', ContactPasswordController::class);

// Currency Rates
Route::get('/currencyrates', [CurrencyRateController::class, 'index'])->name('currencyrates');

// Contact Currency
Route::resource('contactcurrency', ContactCurrencyController::class);

// Archives
Route::get('/archives/download', [ArchiveController::class, 'downloadAll'])->name('archives.download');
Route::get('/archives/download/{name}', [ArchiveController::class, 'downloadFile'])->name('archives.download.file');
Route::get('/archives/generate', [ArchiveController::class, 'generate'])->name('archives.generate');
Route::resource('archives', ArchiveController::class);


