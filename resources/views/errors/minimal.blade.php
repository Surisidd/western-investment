<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">

        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
       
    </head>
    <body>
        <div class="accountbg"></div>
        <div class="wrapper-page">

            <div class="ex-page-content text-center">
                <img src="{{ asset('assets/images/logo.png')}}" class="logo-lg" alt="" height="85">

                <h1 class="text-white">
                    @yield('code')
                </h1>
                <h2 class="text-white">@yield('message')</h2><br>
                <blockquote>@yield('desc')</blockquote>

                <a class="btn btn-primary waves-effect waves-light" href="/"> <span><i class="fas fa-angle-double-left"></i></span> Go Dashboard</a>
            </div>
        </div>
       
    </body>
</html>
