<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Statement PDF</title>
    <style>
        body {
            font-family: 'Inconsolata', monospace;
            letter-spacing: 1.5px;
            /* font-size: 17px; */
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

                <table style="width:90%; margin-left: auto;
        margin-right: auto;margin-bottom:-20px;">
                    <tr>
                        <td style="background-color:#293F4F;  padding: 6px;
             "></td>
                        <td style="background-color:#87BEDF;  padding: 6px;
          "></td>
                        <td style="background-color:#293F4F;  padding: 6px;
          "></td>

                    </tr>


                </table>

            </div>

        </div>
    </htmlpagefooter>



    <div>

        <div class="container">

            <img src="https://sbxke.com/banner.png">

            <div class="container" style="background-color: #293F4F; z-index: -2; position: relative; top: 150px; width: 85%;  margin: 0 auto;
     
  font-weight: bold;

    ">
                <div
                    style="text-align: center;text-transform: uppercase;font-size:30px;padding: 1px 30px;top:20px; z-index:300px; position: absolute;color:white;letter-spacing:3px">
                    MONTHLY STATEMENT <br>
                    <div style="font-size:25px;text-transform:capitalize">
                        {{ date('F Y', strtotime('2021-08-31')) }}</div>
                </div>
            </div>
        </div>
        <div class="container" style="text-align: center;margin-bottom:9px">
            <p style="font-size: 15px;letter-spacing:normal">Name: {{ $data->client }}
                |&nbsp;Fund&nbsp;: {{$data['fund']}}
                 </p>

        </div>
        <div class="container" style="text-align: center;font-weight:bold;font-size: 20px;">
            PORTFOLIO SUMMARY
        </div>

        <div class="container" style="text-align: center;margin-top:-45px">

            <table style="margin-left: auto;
      margin-right: auto;padding:25px;font-size:17px; border-spacing: 60px 15px;
">

                <tr>
                    <td style="text-align: left;">
                        Portfolio Value on 31-07-2021:
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
                        {{ number_format((float) $data['redemption'], 2, '.', ',') }}
                    </td>

                </tr>
                <tr>
                    <td style="text-align: left">
                        Accrued Interest:
                    </td>

                    <td style="text-align: right">
                        {{ number_format((float) $data['return'], 2, '.', ',') }}</td>
                    </td>

                </tr>
                <tr>
                    <td style="text-align: left">
                        Portfolio Value on 31-08-2021:
                    </td>

                    <td style="text-align: right">
                        {{ number_format(intval($data['endValue'] * 100) / 100, 2) }}

                    </td>


                </tr>

            </table>



        </div>


       
        <br>

    
    </div>
</body>

</html>
