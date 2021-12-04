<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Use App\Transactions\Transactions;
class Contact extends Model
{
    use HasFactory;

    protected $primaryKey = 'ContactID';
   
    public function currency()
    {
        return $this->hasOne(ContactCurrency::class, 'ContactID');
    }

    public function password()
    {
        if ($this->contactPassword()->exists()) {
            return $this->contactPassword->password;
        } else {

            return $this->NationalID;
        }
    }

    public function contactPassword()
    {
        return $this->hasOne(ContactPassword::class, 'ContactID');
    }

    public function getFullNameAttribute()
    {
            return ucwords(strtolower($this->DeliveryName));
    }

    public function contactSchedule()
    {
        return $this->hasOne(ContactSchedule::class, 'ContactID');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'OwnerContactID', 'ContactID');
    }


    public function transactions()
    {
        return $this->hasManyThrough(
            PortfolioTransaction::class,
            Portfolio::class,
            'PrimaryContactID', // Foreign key on the Portfolios table...
            'PortfolioID', // Foreign key on the Transactions table...
            'ContactID', // Local key on the Contacts table...
            'PortfolioID' // Local key on the Portfolio table...
        )->select(['TransactionCode','AdvPortfolioTransaction.PortfolioID','TradeDate','SecTypeCode1','SecurityID1','SettleDate','Quantity','SecTypeCode2','SecurityID2','TradeAmount']);
    }


    public function endPortfolio()
    {
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));
        $transactions=new Transactions($this,$startDate,$endDate);
        $summary=$transactions->summary();  
        return $summary["endValue"];
    }

    public function emailactivities()
    {
        return $this->hasMany(EmailActivity::class, 'ContactID');
    }
    
}
