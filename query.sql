select t.SecurityID1,s.FullName,s.PrincipalCurrencyCode,ph.PriceValue as marketPrice,pph.PriceValue as unitPrice, SUM(CASE WHEN t.TradeDate <= '2021-04-30' THEN t.Quantity*tc.EffectOnQuantity*pph.PriceValue ELSE 0 END) AS startValue,
										              SUM(CASE WHEN t.TradeDate >= ? AND t.TradeDate<=? AND t.TransactionCode= ? THEN t.TradeAmount ELSE 0 END) as soldUnits,

                                        SUM(CASE WHEN t.TradeDate <= '2021-05-31' THEN t.Quantity*tc.EffectOnQuantity*ph.PriceValue ELSE 0 END) as endValue
                                        from vQbRowDefContact c 
INNER JOIN vQbRowDefPortfolio p ON c.ContactID=p.PrimaryContactID
INNER JOIN AdvApp.vPortfolioTransaction  t ON t.PortfolioID=p.PortfolioID

INNER JOIN AdvSecurity s ON s.SecurityID=t.SecurityID1
INNER JOIN AdvTransactionCode tc ON tc.TransactionCode=t.TransactionCode
CROSS APPLY 
(
 SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate='2021-05-31'
) ph

CROSS APPLY 
(
 SELECT TOP 1 SecurityID, FromDate, PriceValue FROM AdvPriceHistory ph WHERE ph.SecurityID=t.SecurityID1 AND ph.FromDate='2021-04-30'
) pph
where c.ContactID=6197 AND s.SecTypeBaseCode = 'cs' 
GROUP BY t.SecurityID1,s.FullName, ph.PriceValue, pph.PriceValue,s.PrincipalCurrencyCode
HAVING SUM(CASE WHEN t.TradeDate <= '2021-05-31' THEN t.Quantity*tc.EffectOnQuantity ELSE 0 END) >0.5