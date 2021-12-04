<x-app-layout>
    <x-slot name="title">
         
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href=" {{route('contacts.show',$portfolio->contact->ContactID)}} ">{{$portfolio->contact->full_name}}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$portfolio->PortfolioCode}}</li>
            </ol>
          </nav>
       
    </x-slot>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

              
                <div class="card-body" style="font-family: Consolas, monaco, monospace">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center ">
                                {{-- <img src=" {{ asset('assets/images/banner.png')}}" class="img-fluid"> --}}
                                <div class="d-flex justify-content-center">
                                    <div class="border  rounded-sm"
                                        style="background-color: #293F4F;font-size: 15px;">
                                        <p class="h1 text-uppercase font-weight-bold text-white">Monthly Statement</p>
                                        <p class="text-uppercase text-white"> {{ date('F Y', strtotime($endDate)) }}</p>
                                    </div>
                                </div>
<hr>
                            </div>

                            <div class="d-flex justify-content-center " >
                                <p class="h4 text-center">Name: {{$portfolio->ReportHeading1}} |&nbsp;Client&nbsp;No:&nbsp;{{$portfolio->PortfolioCode}}</p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <h3 class="text-uppercase">Portfolio Summary</h3>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">

                        <table class="table table-responsive">

                            <table class="table">

                                <tbody>
                                    <tr>

                                        <td>Portfolio Value On {{ $startDate}}:
                                        </td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{number_format((float)$startPortfolio,2,'.',',')}}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>Contributions:</td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$contributions,2,'.',',')}}</td>

                                    </tr>
                                    <tr>

                                        <td>Withdrawals:</td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$withdrawals,2,'.',',')}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Accrued Interest: </td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$accruedInterest,2,'.',',')}}</td>
                                    </tr>

                                    <tr>

                                        <td>Portfolio Value On {{$endDate}}:</td>
                                        <td class="text-right" style="font-weight: bold">

                                            {{number_format(intval(($endPortfolio*100))/100,2)}}

                                            {{-- {{ number_format((float)$endPortfolio,2,'.',',')}} --}}
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header text-center">
                                <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead style="background-color:#87BEDF; color:white">
                                            <tr>
                                                <td><strong>Quantity</strong></td>
                                                <td class="text-center"><strong>Security</strong></td>
                                                <td class="text-center"><strong>Unit&nbsp;Cost</strong>
                                                </td>
                                                <td class="text-center"><strong>Total&nbsp;Cost</strong>
                                                </td>
                                                <td class="text-center"><strong>Price</strong>
                                                </td>
                                                <td class="text-center"><strong>Market&nbsp;Value</strong>
                                                </td>
                                                {{-- <td class="text-right"><strong>Pct Assets</strong></td> --}}
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($kesMoneyMarketTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($kesMoneyMarketQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western KES Money Market Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($kesMoneyMarketUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($kesMoneyMarketTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($kesMoneyMarketPrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($kesMoneyMarketMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>
                                            @endif

                                            {{-- Fixed Income --}}
                                            @if ($fixedIncomeTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($fixedIncomeQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western KES Fixed Income Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($fixedIncomeUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($fixedIncomeTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($fixedIncomePrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($fixedIncomeMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>
                                            @endif

                                            {{-- Western Africa Money Market --}}
                                            @if ($africaMoneyMarketTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($africaMoneyMarketQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western Africa Money Market Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaMoneyMarketUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaMoneyMarketTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaMoneyMarketPrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($africaMoneyMarketMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>
                                            @endif


                                            {{-- Western Africa Balanced Fund --}}
                                            @if ($africaBalancedTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($africaBalancedQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western Africa Balanced Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaBalancedUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaBalancedTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaBalancedPrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($africaBalancedMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>

                                            @endif


                                            {{-- Euqity Fund --}}

                                            @if ($africaEquityTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($africaEquityQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western Africa Equity Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaEquityUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaEquityTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaEquityPrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($africaEquityMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>
                                            @endif

                                            {{-- Western Africa Fixed Income Fund --}}
                                            @if ($africaFixedIncomeTotalCost > 0)
                                            <tr>
                                                {{-- Quantity --}}
                                                <td>
                                                    {{number_format(intval(($africaFixedIncomeQuantity*100))/100,2)}}

                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    Western Africa Fixed Income Fund
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaFixedIncomeUnitCost*100))/100,2)}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaFixedIncomeTotalCost*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($africaFixedIncomePrice*100))/100,2)}}
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">

                                                    {{number_format(intval(($africaFixedIncomeMarketValue*100))/100,2)}}

                                                </td>
                                            </tr>

                                            @endif

                                              {{-- NIF --}}

                                              @isset($bonds)
                                              @forelse ($bonds as $bond)
                                              <tr>
                                                  {{-- Quantity --}}
                                                  <td>
                                                      --
                                                  </td>
                                                  {{-- Security Name --}}
                                                  <td class="text-center">
                                                      {{$bond->security->FullName}}
                                                  </td>   
                                                  {{-- Unit Price --}}
                                                  <td class="text-center">
                                                      --
                                                  </td>
  
                                                  {{-- Total Cost --}}
                                                  <td class="text-center">
                                                      {{number_format(intval(($bond->TradeAmount*100))/100,2)}}
  
                                                  </td>
  
                                                  {{-- Market Price --}}
                                                  <td class="text-center">
                                                      --
                                                  </td>
  
                                                  {{-- Market Value --}}
                                                  <td class="text-center">
  
                                                    {{number_format(intval(((interests($bond->TradeAmount,$bond->security->SecurityID,$startDate,$endDate) + $bond->TradeAmount)*100))/100,2)}}
  
  
  
                                                  </td>
                                              </tr>
                                              @empty
                                                  
                                              @endforelse
                                              @endisset

                                            
                                           


                                            <tr class="mt-0">
                                                <td class="no-line col-span-5">
                                                    ------
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line text-left">
                                                    <p class="h5"><strong>Total&nbsp;Portfolio</strong>
                                                </td>
                                                </p>
                                                <td class="no-line"></td>

                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <h4 class="m-0">
                                                        {{number_format(intval(($startPortfolio*100))/100,2)}}
                                                    </h4>
                                                </td>

                                                <td class="no-line"></td>

                                                <td class="no-line text-center">
                                                    <h4 class="m-0">
                                                        {{number_format(intval(($endPortfolio*100))/100,2)}}
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="hidden-print">
                                    <div class="float-right">
                                        <a class="btn btn-info waves-effect waves-light"  href=" {{route('contact.portfolio.pdf',[$portfolio->contact->ContactID,$portfolio->PortfolioID])}} ">Download&nbsp;PDF &nbsp;<i class="fas fa-file-pdf"></i></a>
                                        {{-- <a href="javascript:window.print()"
                                            class="btn btn-success waves-effect waves-light"><i
                                                class="fa fa-print"></i></a> --}}
                                        <a href=" {{route('contacts.sendstatement',$portfolio->PortfolioID)}} "
                                            class="btn btn-primary waves-effect waves-light">Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="m-b-30 m-t-0 text-center">Transaction History</h4>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Transaction</th>
                                                                <th scope="col">Security</th>
                                                                <th scope="col">Trade Date</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Trade Amount</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- @forelse ($transactions->where('TradeDate','>=', $startDate)   as $transaction) --}}
                                                            @forelse ($transactions as $transaction)

                                                            <tr>
                                                                <th scope="row"> 


                                                                    {{$transaction->SecurityID1}}
                                                                    {{$transaction->PrincipalCurrencyCode}}

                                                                    {{-- PortfolioTransactionID --}}

                                                                    
                                                                    {{$transaction->transaction->name()}}
                                                                </th>
                                                                <td> {{$transaction->security? $transaction->security->FullName:"" }}
                                                                </td>
                                                                <td>{{$transaction->TradeDate}}</td>
                                                                <td>
                                                                    {{number_format(intval(($transaction->Quantity*100))/100,3)}}
                                                                </td>
                                                                <td>
                                                                    {{-- {{$transaction->PortfolioTransactionID}} --}}
                                                                    {{number_format(intval(($transaction->TradeAmount*100))/100,2)}}

                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5">
                                                                    No Transactions History
                                                                </td>
                                                            </tr>
                                                            @endforelse



                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="d-flex justify-content-center">
                            <p class="w-50 text-center"> 5th Floor, International House, Mama Ngina St. P.O Box 10518 –
                                00100
                                Kenya. 0709 902 700 invest@Westerncapital.com
                                <br>
                                www.Westerncapital.com
                            </p>
                        </div>
                    </div>

                </div> <!-- end row -->
            </div> <!-- panel body -->
        </div> <!-- end panel -->

    </div> <!-- end col -->

    </div>
</x-app-layout>