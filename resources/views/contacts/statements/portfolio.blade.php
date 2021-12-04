<x-app-layout>
    <x-slot name="title">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href=" {{route('contacts.show',$contact->ContactID)}} ">{{$contact->full_name}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$portfolioCode}}</li>
            </ol>
        </nav>

    </x-slot>
    @if (isset($data))
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
                                {{-- <img src=" {{ asset('assets/images/banner.png')}}" class="img-fluid"> --}}
                                <div class="d-flex justify-content-center m-2">
                                    <form class="form-horizontal"
                                        action=" {{route('contacts.portfolio',[$data["portfolio"]->PortfolioID])}}"
                                        method="GET">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">From</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="startDate"
                                                    value="{{ date('Y-m-d', strtotime($data["startDate"])) }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">To</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="endDate"
                                                    value="{{ date('Y-m-d', strtotime($data["endDate"])) }}">
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
                                            {{ date('F Y', strtotime($data["endDate"])) }}</p>
                                    </div>
                                </div>

                                <hr>
                            </div>

                            <div class="d-flex justify-content-center ">
                                <p class="h4 text-center">Name: {{$data["portfolio"]->ReportHeading1}}
                                    |&nbsp;Client&nbsp;No:&nbsp;{{$data["portfolio"]->PortfolioCode}}</p>
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

                                        <td>Portfolio Value On {{ $data["startDate"]}}:
                                        </td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{number_format((float)$data["startValue"],2,'.',',')}}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>Contributions:</td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$data["contributions"],2,'.',',')}}</td>

                                    </tr>
                                    <tr>

                                        <td>Withdrawals:</td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$data["withdrawals"],2,'.',',')}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Accrued Interest: </td>
                                        <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$data["interest"],2,'.',',')}}</td>
                                    </tr>

                                    <tr>

                                        <td>Portfolio Value On {{$data["endDate"]}}:</td>
                                        <td class="text-right" style="font-weight: bold">

                                            {{number_format(intval(($data["endValue"]*100))/100,2)}}

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

                                            <tr>
                                                {{-- Units --}}
                                                <td>
                                                    @if ($data["TotalUnits"]>0)
                                                    {{number_format(intval(($data["TotalUnits"]*100))/100,2)}}

                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                                {{-- Security Name --}}
                                                <td class="text-center">
                                                    {{$data["Name"]->security->FullName}}
                                                </td>
                                                {{-- Unit Price --}}
                                                <td class="text-center">
                                                    @if (isset($data["unitCost"]))
                                                    {{number_format(intval(($data["unitCost"]*100))/100,2)}}

                                                    @else
                                                    ---
                                                    @endif
                                                    {{-- {{number_format(intval(($data["Name"]["UnitCost"]*100))/100,2)}}
                                                    --}}
                                                </td>

                                                {{-- Total Cost --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($data["startValue"]*100))/100,2)}}
                                                </td>

                                                {{-- Market Price --}}
                                                <td class="text-center">
                                                    @if (isset($data["marketPrice"]))
                                                    {{number_format(intval(($data["marketPrice"]*100))/100,2)}}

                                                    @else
                                                    ---
                                                    @endif
                                                </td>

                                                {{-- Market Value --}}
                                                <td class="text-center">
                                                    {{number_format(intval(($data["TotalMarket"]*100))/100,2)}}
                                                </td>
                                            </tr>

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
                                                        {{number_format(intval(($data["startValue"]*100))/100,2)}}
                                                    </h4>
                                                </td>

                                                <td class="no-line"></td>

                                                <td class="no-line text-center">
                                                    <h4 class="m-0">
                                                        {{number_format(intval(($data["endValue"]*100))/100,2)}}
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="hidden-print">
                                    <div class="float-right">
                                        <form class="mb-1"
                                            action=" {{route("contacts.portfolio.download",$data["portfolio"]->PortfolioID)}} "
                                            method="GET">
                                            <input type="hidden"  name="startDate" value=" {{$data["startDate"]}} "/>
                                            <input type="hidden" name="endDate"  value=" {{$data["endDate"]}} "/>
                                            <button type="submit"
                                                class="btn btn-info waves-effect waves-light">Download&nbsp;<i class="fas fa-download"></i></button>
                                        </form>
                                        <form action=" {{route("contacts.portfolio.send",$data["portfolio"]->PortfolioID)}} " method="POST">
                                            @csrf
                                            <input type="hidden"  name="startDate" value=" {{$data["startDate"]}} "/>
                                            <input type="hidden" name="endDate"  value=" {{$data["endDate"]}} "/>

                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Send
                                                <span><i class="far fa-paper-plane"></i></span></a>
                                        </form>

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
                                                            @forelse ($data["transactions"] as $transaction)

                                                            <tr>
                                                                <th scope="row">

                                                                  
                                                                


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
    @else
        <div class="row">
            <div class="container-fluid">
                <div class="mb-4 bg-light rounded-3 mt-1">
                    <div class="container-fluid ">
                      <h2 class="display-5 fw-bold">Sorry, we don't support this portfolio</h2>
                      <p class="col-md-8 fs-2">However, we are working to make it work!</p>
                      <a href=" {{route("contacts.show",$contact->ContactID)}} " class="btn btn-primary" type="button"><span><i class="fas fa-angle-double-left"></i></span>&nbsp;Go Back</a>
                    </div>
                  </div>
            </div>
        </div>
    @endif
   

    </div>
</x-app-layout>