<x-app-layout>
    <x-slot name="title">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('contacts.show', $contact->ContactID) }}
        ">{{ $contact->full_name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">All Portfolios</li>
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body" style="font-family: Consolas, monaco, monospace">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="text-center">
                                <div class="d-flex justify-content-center ">
                                    <p class="h4 text-center"> {{ $contact->full_name }} </p>
                                </div>
                                <div class="d-flex justify-content-center m-2">
                                    <form class="form-horizontal"
                                        action=" {{ route('test.contacts.summary', $contact->ContactID) }}" method="GET">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">From</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="startDate"
                                                    value="{{ date('Y-m-d', strtotime($startDate)) }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">To</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="endDate" value="{{ date('Y-m-d', strtotime($endDate)) }}">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary" type="submit">Generate </button>
                                            </div>
                                        </div>


                                    </form>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="border  rounded-sm p-2"
                                        style="background-color: #293F4F;font-size: 15px;">
                                        <p class="h4 text-uppercase font-weight-bold text-white">Monthly Statement</p>
                                        <p class="text-uppercase text-white">
                                            {{ date('F Y', strtotime($endDate)) }}</p>
                                    </div>
                                </div>

                                <hr>
                            </div>

                            <div class="text-center">
                                <h3 class="text-uppercase">Consolidated Portfolio Summary</h3>
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
                                        <td></td>

                                        @if ($summary['startValue']>0)
                                        <td style="font-weight: bold" class="text-right">KES</td>

                                        @endif
                                        @if ($summary['startValueUSD']>0)
                                        <td style="font-weight: bold" class="text-right">
                                          
                                            USD
                                            
                                        </td>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td>Portfolio Value On {{ $startDate }}:
                                        </td>
                                        @if ($summary['endValue']>0)   
                                            <td class="text-right" style="font-weight: bold">
                                                {{ number_format((float) $summary['startValue'], 2, '.', ',') }}
                                            </td>                                         
                                        @endif
                                       
                                        @if ($summary['startValueUSD']>0)
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float) $summary['startValueUSD'], 2, '.', ',') }}
                                        </td>
                                        @endif
                                       
                                    </tr>
                                    <tr>

                                        <td>Contributions:</td>
                                        @if ($summary['endValue']>0)   
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float) $summary['contributions'], 2, '.', ',') }}
                                        </td>                                    
                                    @endif
                                       
                                    @if ($summary['endValueUSD']>0)
                                    <td class="text-right" style="font-weight: bold" >
                                        {{ number_format((float) $summary['contributionsUSD'], 2, '.', ',') }}

                                    </td>
                                    @endif
                                       
                                    </tr>
                                    <tr>

                                        <td>Withdrawals:</td>

                                        @if ($summary['endValue']>0)   
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float) $summary['withdrawals'], 2, '.', ',') }}
                                        </td>                                 
                                    @endif
                                       

                                        @if ($summary['endValueUSD']>0)
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float) $summary['withdrawalsUSD'], 2, '.', ',') }}
                                        </td>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td>Accrued Interest: </td>
                                        @if ($summary['endValue']>0)   
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float) $summary['interest'], 2, '.', ',') }}
                                            </td>                               
                                    @endif
                                       
                                      @if ($summary['endValueUSD']>0)
                                      <td class="text-right" style="font-weight: bold">
                                        {{ number_format((float) $summary['interestUSD'], 2, '.', ',') }}
                                        </td>
                                      @endif
                                    </tr>

                                    <tr>

                                        <td>Portfolio Value On {{ $endDate }}:</td>

                                        @if ($summary['endValue']>0)   
                                        <td class="text-right" style="font-weight: bold">

                                            {{ number_format(intval($summary['endValue'] * 100) / 100, 2) }}

                                        </td>                            
                                    @endif
                                       

                                        @if ($summary['endValueUSD']>0)
                                        <td class="text-right" style="font-weight: bold">

                                            {{ number_format(intval($summary['endValueUSD'] * 100) / 100, 2) }}

                                        </td>
                                        @endif

                                    </tr>

                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            @foreach ($mutualfunds as $mutualfund)

                                <div class="card-header text-center">
                                    <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">

                                            <table class="table table-responsive">

                                                <table class="table">
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            <h4>
                                                                {{ $mutualfund->FullName }}
                                                            </h4>
                                                        </td>
                                                    </tr>

                                                    <tbody>
                                                        <tr>
                                                            <td>Portfolio Value On {{ $startDate }}:
                                                            </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $mutualfund->startValue, 2, '.', ',') }}
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>Contributions:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $mutualfund->contributions, 2, '.', ',') }}
                                                            </td>



                                                        </tr>
                                                        <tr>

                                                            <td>Withdrawals:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $mutualfund->withdrawals, 2, '.', ',') }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>Accrued Interest: </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $mutualfund->interest, 2, '.', ',') }}
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td>Portfolio Value On {{ $endDate }}:</td>
                                                            <td class="text-right" style="font-weight: bold">

                                                                {{ number_format(intval($mutualfund->endValue * 100) / 100, 2) }}

                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead style="background-color:#87BEDF; color:white">
                                                <tr>
                                                    <td class="text-center"><strong>Quantity</strong></td>
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



                                                <tr>
                                                    <td class="text-center">
                                                        {{ number_format((float) $mutualfund->quantity, 2, '.', ',') }}
                                                    </td>

                                                    <td class="text-center"> {{ $mutualfund->FullName }} </td>
                                                    <td class="text-center">
                                                        {{ number_format((float) $mutualfund->unitPrice, 2, '.', ',') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format((float) $mutualfund->startValue, 2, '.', ',') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format((float) $mutualfund->marketPrice, 2, '.', ',') }}
                                                    </td>

                                                    <td class="text-center">
                                                        {{ number_format((float) $mutualfund->endValue, 2, '.', ',') }}
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($equities as $equity)

                            <div class="card-header text-center">
                                <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-auto">

                                        <table class="table table-responsive">

                                            <table class="table">
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        <h4>
                                                            {{ $equity->FullName }}
                                                        </h4>
                                                    </td>
                                                </tr>

                                                <tbody>
                                                    <tr>
                                                        <td>Portfolio Value On {{ $startDate }}:
                                                        </td>
                                                        <td class="text-right" style="font-weight: bold">
                                                            {{ number_format((float) $equity->startValue, 2, '.', ',') }}
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Contributions:</td>
                                                        <td class="text-right" style="font-weight: bold">
                                                            {{ number_format((float) $equity->contributions, 2, '.', ',') }}
                                                        </td>



                                                    </tr>
                                                    <tr>

                                                        <td>Withdrawals:</td>
                                                        <td class="text-right" style="font-weight: bold">
                                                            {{ number_format((float) $equity->withdrawals, 2, '.', ',') }}
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>Accrued Interest: </td>
                                                        <td class="text-right" style="font-weight: bold">
                                                            {{ number_format((float) $equity->interest, 2, '.', ',') }}
                                                        </td>
                                                    </tr>

                                                    <tr>

                                                        <td>Portfolio Value On {{ $endDate }}:</td>
                                                        <td class="text-right" style="font-weight: bold">

                                                            {{ number_format(intval($equity->endValue * 100) / 100, 2) }}

                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </table>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead style="background-color:#87BEDF; color:white">
                                            <tr>
                                                <td class="text-center"><strong>Quantity</strong></td>
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



                                            <tr>
                                                <td class="text-center">
                                                    {{ number_format((float) $equity->quantity, 2, '.', ',') }}
                                                </td>

                                                <td class="text-center"> {{ $equity->FullName }} </td>
                                                <td class="text-center">
                                                    {{ number_format((float) $equity->unitPrice, 2, '.', ',') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format((float) $equity->startValue, 2, '.', ',') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format((float) $equity->marketPrice, 2, '.', ',') }}
                                                </td>

                                                <td class="text-center">
                                                    {{ number_format((float) $equity->endValue, 2, '.', ',') }}
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                          
@if ($fixedincome)

<div class="card-header text-center">
    <h5 class="card-title text-dark m-0"><strong>Fixed&nbsp;Income</strong></h5>
</div>

<div class="card-body">
   
    <div class="table-responsive">
        <table class="table">
            <thead style="background-color:#87BEDF; color:white">
                <tr>
                    <td class="text-center"><strong>Quantity</strong></td>
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
                @foreach ($fixedincome as $fi)
                <tr>
                    <td class="text-center"> --- </td>

                    <td class="text-center"> {{ $fi->FullName }} </td>
                    <td class="text-center"> --- </td>
                    <td class="text-center">
                        {{ number_format((float) $fi->startValue, 2, '.', ',') }} </td>
                    <td class="text-center"> --- </td>

                    <td class="text-center">
                        {{ number_format((float) $fi->endValue, 2, '.', ',') }} </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>


</div>
@endif
                             

                            @foreach ($fixedDeposits as $fd)

                                <div class="card-header text-center">
                                    <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">

                                            <table class="table table-responsive">

                                                <table class="table">
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            <h4>
                                                                {{ $fd->FullName }}
                                                            </h4>
                                                        </td>
                                                    </tr>

                                                    <tbody>
                                                        <tr>
                                                            <td>Portfolio Value On {{ $startDate }}:
                                                            </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $fd->startValue, 2, '.', ',') }}
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>Contributions:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $fd->contributions, 2, '.', ',') }}
                                                            </td>



                                                        </tr>
                                                        <tr>

                                                            <td>Withdrawals:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $fd->withdrawals, 2, '.', ',') }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>Accrued Interest: </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float) $fd->interest, 2, '.', ',') }}
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td>Portfolio Value On {{ $endDate }}:</td>
                                                            <td class="text-right" style="font-weight: bold">

                                                                {{ number_format(intval($fd->endValue * 100) / 100, 2) }}

                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead style="background-color:#87BEDF; color:white">
                                                <tr>
                                                    <td class="text-center"><strong>Quantity</strong></td>
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



                                                <tr>
                                                    <td class="text-center"> --- </td>

                                                    <td class="text-center"> {{ $fd->FullName }} </td>
                                                    <td class="text-center"> --- </td>
                                                    <td class="text-center">
                                                        {{ number_format((float) $fd->startValue, 2, '.', ',') }} </td>
                                                    <td class="text-center"> --- </td>

                                                    <td class="text-center">
                                                        {{ number_format((float) $fd->endValue, 2, '.', ',') }} </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            @endforeach

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
                                                                @forelse ($latestTransactions as $transaction)

                                                                    <tr>
                                                                        <th scope="row">




                                                                            {{-- PortfolioTransactionID --}}

                                                                            {{ $transaction->TransactionLabel }}
                                                                        </th>
                                                                        <td> {{ $transaction->FullName }}
                                                                        </td>
                                                                        <td>{{ $transaction->TradeDate }}</td>
                                                                        <td>
                                                                            {{ number_format(intval($transaction->Quantity * 100) / 100, 3) }}
                                                                        </td>
                                                                        <td>
                                                                            {{-- {{$transaction->PortfolioTransactionID}} --}}
                                                                            {{ number_format(intval($transaction->TradeAmount * 100) / 100, 2) }}
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
                                                    <hr>
                                                    <div class="hidden-print">
                                                        <div class="float-right">
                                                            <form class="mb-1"  target="_blank"
                                                                action=" {{ route('test.contacts.consolidated.pdf', $contact->ContactID) }} "
                                                                method="GET">
                                                                <input type="hidden" name="startDate"
                                                                    value=" {{ $startDate }} " />
                                                                <input type="hidden" name="endDate"
                                                                    value=" {{ $endDate }} " />
                                                                <button type="submit"
                                                                    class="btn btn-info waves-effect waves-light">Download&nbsp;<i
                                                                        class="fas fa-download"></i></button>
                                                            </form>
                                                            <form
                                                            action=" {{route('test.summary.send',$contact->ContactID)}} "
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="startDate"
                                                                    value=" {{ $startDate }} " />
                                                                <input type="hidden" name="endDate"
                                                                    value=" {{ $endDate }} " />

                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light">Send
                                                                    <span><i class="far fa-paper-plane"></i></span></a>
                                                            </form>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                    </div>

                </div> <!-- end row -->
            </div> <!-- panel body -->
        </div> <!-- end panel -->

    </div> <!-- end col -->



    </div>
    </div>

</x-app-layout>
