$fixedincome = DB::connection('sqlsrv')->select('select t.SecurityID1,s.FullName,s.MaturityDate,drs.Rate, t.TradeDate,t.TradeAmount,
((((drs.Rate/36500)*(DATEDIFF(day,t.tradedate,?))*t.TradeAmount)))+t.TradeAmount as endValue,
((((drs.Rate/36500)*(DATEDIFF(day,t.tradedate,?))*t.TradeAmount)))+t.TradeAmount as startValue,
((drs.Rate/36500)*(DATEDIFF(day,?,?)+1))*t.TradeAmount as interest

from advapp.vcontact c 
INNER JOIN AdvApp.vPortfolio p ON c.ContactID=p.PrimaryContactID
INNER JOIN  AdvApp.vPortfolioTransaction as t ON t.PortfolioID=p.PortfolioID
INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
INNER JOIN AdvDateRate dr ON dr.DateRateName=s.Symbol
INNER JOIN AdvDateRateSchedule drs ON dr.DateRateID=drs.DateRateID 
where c.ContactID=? AND t.Sectypecode2 = ? AND MaturityDate >=? AND drs.Rate IS NOT NULL  AND t.TradeAmount > 0

GROUP BY t.SecurityID1, s.FullName,s.MaturityDate,drs.Rate, t.TradeDate, t.TradeAmount',[
    $this->endDate,
    $this->startDate,
    $this->startDate,
    $this->endDate,
    $this->contact->ContactID,
    'ca',
    $this->startDate,
    ]);

return $fixedincome;