<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consolidated Statement PDF</title>
    <style>
        body {
            font-family: 'Inconsolata', monospace;
            letter-spacing: 1.5px;

            font-weight: normal;

        }

        @page {
            header: page-header;
            footer: page-footer;
            margin: 15px;
            margin-header: 15px;
            margin-footer: 15px;
        }

        .blueheaders {
            background-color: aqua;
            border: 1px solid black;

        }

        table tr th {
            background-color: #87BEDF;
            width: 15%;
            color: white;
        }

        table th {
            padding: 20px;

        }

        .borderx {
            border: 1px solid #999;
            padding: 0.5rem;
            text-align: left;
        }

        td {
            text-align: center;
        }

    </style>

</head>

<body>


    <htmlpagefooter name="page-footer">
        <div style="text-align: center">
            <p>
                {{-- https://i.postimg.cc/JnF8QhH2/Statements-Graphics-Youtube-banner.png --}}
                <a href="https://www.youtube.com/channel/UCOAMPvt7oJJI1lch6i9W5tg"><img
                        src="https://i.postimg.cc/JnF8QhH2/Statements-Graphics-Youtube-banner.png" alt="youtube"
                        border="0"></a>
            </p>


            <div style="text-align:center;width:100%">

                <p style="margin-top: 20px;font-size:9px">
                    5th Floor, International House, Mama Ngina St. P.O Box 10518 – 00100 Nairobi <br>
                    Kenya. 0709 902 700 invest@Westerncapital.com <br>
                    <a href="https://Westerncapital.com">www.Westerncapital.com</a>
                </p>

                <table style="width:90%; margin-left: auto;margin-right: auto;margin-bottom:-20px;">
                    <tr>
                        <td style="background-color:#293F4F;  padding: 6px;"></td>
                        <td style="background-color:#87BEDF;  padding: 6px;"></td>
                        <td style="background-color:#293F4F;  padding: 6px;"></td>
                    </tr>


                </table>

            </div>

        </div>
    </htmlpagefooter>

    <div class="container">

        <img src="https://sbxke.com/banner.png">

        <div class="container" style="background-color: #293F4F; z-index: -2; position: relative; top: 150px; width: 85%;  margin: 0 auto;font-weight: bold;">
            <div
                style="text-align: center;text-transform: uppercase;font-size:30px;padding: 1px 30px;top:20px; z-index:300px; position: absolute;color:white;letter-spacing:3px">
                MONTHLY STATEMENT <br>
                <div style="font-size:25px;text-transform:capitalize">{{ date('F Y', strtotime($endDate)) }}</div>
            </div>
        </div>
        <div class="container" style="text-align: center;margin-bottom:-55px">
            <p style="font-size: 17px;letter-spacing:normal">Name: {{ $contact->full_name }}</p>
        </div>

    </div>

    <div class="container" style="text-align: center;">

        <table
            style="margin-left: auto;margin-right: auto;padding:25px;font-size:17px; border-spacing: 60px 15px;page-break-inside: avoid;">
         
            <tr>
                <td colspan="3">
                    <div class="container" style="text-align: center;font-weight:bold;font-size: 22px;">

                        <h6>
                            CONSOLIDATED PORTFOLIO SUMMARY
                        </h6>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right">KES</td>
                @if ($summaryUSD["endValue"]>0)
                    <td style="text-align: right">USD</td>
                @endif

            </tr>
            <tr>
                <td style="text-align: left; white-space:nowrap" >
                    Portfolio Value on {{ $startDate }}:
                </td>


                <td style="text-align: right">
                    {{ number_format((float) $summaryKES['startValue'], 2, '.', ',') }}
                </td>

                @if ($summaryUSD["endValue"]>0)

                <td style="text-align: right">
                    {{ number_format((float) $summaryUSD['startValue'], 2, '.', ',') }}
                </td>

                @endif

            </tr>
            <tr>
                <td style="text-align: left">
                    Contributions:
                </td>

                <td style="text-align: right">
                    {{ number_format((float) $summaryKES['contributions'], 2, '.', ',') }}</td>
                </td>
                @if ($summaryUSD["endValue"]>0)

                <td style="text-align: right">
                    {{ number_format((float) $summaryUSD['contributions'], 2, '.', ',') }}</td>
                </td>
                @endif

            </tr>
            <tr>
                <td style="text-align: left">
                    Withdrawals:
                </td>

                <td style="text-align: right">
                    {{ number_format((float) $summaryKES['withdrawals'], 2, '.', ',') }}
                </td>
                @if ($summaryUSD["endValue"]>0)

                <td style="text-align: right">
                    {{ number_format((float) $summaryUSD['withdrawals'], 2, '.', ',') }}
                </td>
                @endif

            </tr>
            <tr>
                <td style="text-align: left">
                    Accrued Interest:
                </td>

                <td style="text-align: right">
                    {{ number_format((float) $summaryKES['interest'], 2, '.', ',') }}</td>
                </td>

                @if ($summaryUSD["endValue"]>0)

                <td style="text-align: right">
                    {{ number_format((float) $summaryUSD['interest'], 2, '.', ',') }}</td>
                </td>
                @endif

            </tr>
            <tr>
                <td style="text-align: left">
                    Portfolio Value on {{ $endDate }}:
                </td>

                <td style="text-align: right">
                    {{ number_format(intval($summaryKES['endValue'] * 100) / 100, 2) }}

                </td>
                @if ($summaryUSD["endValue"]>0)
                    <td style="text-align: right">
                        {{ number_format(intval($summaryUSD['endValue'] * 100) / 100, 2) }}

                    </td>
                @endif
               


            </tr>

        </table>

    </div>

 
    @foreach ($contact->portfolios as $portfolio)
        @php
            $data = portfolio($portfolio, $startDate, $endDate);
        @endphp
        @if (isset($data))

            @if ($data['endValue'] > 5)

           

                <div class="container" style="text-align: center;">

                    <table
                        style="margin-left: auto;margin-right: auto;padding:25px;font-size:17px; border-spacing: 60px 15px;page-break-inside: avoid;">
                        @if ($loop->first)
                        <tr>
                            <td colspan="2">
                                <h5>Breakdown of Holdings</h5>
                            </td>
                        </tr>
                        @endif

                        <tr>
                            <td colspan="2">
                                <p style="font-size: 16px;letter-spacing:normal"> {{ $data['Name']->security->FullName }} </p>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="container" style="text-align: center;font-weight:bold;font-size: 22px;">

                                    <h6>
                                        PORTFOLIO SUMMARY
                                    </h6>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                Portfolio Value on {{ $data['startDate'] }}:
                            </td>


                            <td style="text-align: right">
                                {{ number_format((float) $data['startValue'], 2, '.', ',') }}
                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Contributions:
                            </td>

                            <td style="text-align: right">
                                {{ number_format((float) $data['contributions'], 2, '.', ',') }}</td>
                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Withdrawals:
                            </td>

                            <td style="text-align: right">
                                {{ number_format((float) $data['withdrawals'], 2, '.', ',') }}
                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Accrued Interest:
                            </td>

                            <td style="text-align: right">
                                {{ number_format((float) $data['interest'], 2, '.', ',') }}</td>
                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Portfolio Value on {{ $data['endDate'] }}:
                            </td>

                            <td style="text-align: right">
                                {{ number_format(intval($data['endValue'] * 100) / 100, 2) }}

                            </td>


                        </tr>

                    </table>

                </div>

              
                <table class="table table-bordered mb-0" style="page-break-inside:avoid">
                    <tr>
                        <td colspan="6">
                            <p style="font-size: 22px;text-align: center;font-weight:bold">
                                PORTFOLIO HOLDINGS
                            </p>
                            </div>
                        </td>
                    </tr>

                    <thead>
                        <tr style="text-align: center">
                            <th scope="col">Quantity</th>
                            <th scope="col">Security</th>
                            <th scope="col">Unit&nbsp;Cost</th>
                            <th scope="col">Total&nbsp;Cost</th>
                            <th scope="col">Price</th>
                            <th scope="col">Market&nbsp;Value</th>

                        </tr>
                    </thead>

                    <tr>
                        <td>
                            @if ($data['TotalUnits'] > 0)
                                {{ number_format(intval($data['TotalUnits'] * 100) / 100, 2) }}

                            @else
                                ---
                            @endif
                        </td>
                        <td style="font-size: 12px">
                            {{$data["Name"]->security->FullName}}
                        </td>
                        {{-- Unit Price --}}
                        <td>
                            @if (isset($data["unitCost"]))
                            {{number_format(intval(($data["unitCost"]*100))/100,2)}}

                            @else
                            ---
                            @endif
                            {{-- {{number_format(intval(($data["Name"]["UnitCost"]*100))/100,2)}}
                            --}}
                        </td>
                        {{-- TotalCost --}}
                        <td>
                            {{ number_format(intval($data['startValue'] * 100) / 100, 2) }}

                        </td>
                        {{-- Market Price --}}
                        <td>
                            @if (isset($data["marketPrice"]))
                                                {{number_format(intval(($data["marketPrice"]*100))/100,2)}}
                                                @else
                                                ---
                                                @endif

                        </td>

                        {{-- Market Value --}}
                        <td>

                            {{ number_format(intval($data['TotalMarket'] * 100) / 100, 2) }}

                        </td>

                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight: bold">TOTAL PORTFOLIO</td>

                        <td style="border-top:1px dotted black;">
                            {{ number_format(intval($data['startValue'] * 100) / 100, 2) }}

                        </td>

                        <td> </td>
                        <td style="border-top:1px dotted black;">
                            {{ number_format(intval($data['endValue'] * 100) / 100, 2) }}
                        </td>
                    </tr>

                </table>
                <br>

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">


                                            <table class="table table-bordered mb-0" style="page-break-inside:avoid">
                                                <tr>
                                                    <td colspan="5">
                                                        <p style="font-size: 22px;text-align: center;font-weight:bold">
                                                            TRANSACTION HISTORY
                                                        </p>
                                                    </div>
                                        </td>
                                        </tr>

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
                                            @forelse ($data["transactions"]->where('TradeDate','>=',$data["startDate"])->where('TradeDate','<=',$data["endDate"]) as $transaction)
                                                    <tr>
                                                        <td scope="row"> {{ $transaction->transaction->name() }}
                                                        </td>
                                                        <td>
                                                            {{ $transaction->security ? $transaction->security->FullName : '' }}
                                                        </td>
                                                        <td>{{ $transaction->TradeDate }}</td>
                                                        <td>
                                                            {{ number_format(intval($transaction->Quantity * 100) / 100, 3) }}
                                                        </td>
                                                        <td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            @endif


        @endif
    @endforeach






</body>

</html>