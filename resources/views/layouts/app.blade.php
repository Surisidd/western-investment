<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Western APX') }}</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}" type="image/x-icon">
        <link rel="icon" href="{{ asset('assets/images/favicon.ico')}}" type="image/x-icon">

      
        <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css')}}">
        @yield('css')
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


        <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

        @livewireStyles

        <!-- Scripts -->
        {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
    </head>
    <body>

        <div class="header-bg">
            <!-- Navigation Bar-->
            @auth
            @include('layouts.navbar.header');

            @endauth
            <!-- End Navigation Bar-->

        </div>
        <!-- header-bg -->

        <div class="wrapper">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12" >
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="page-title m-0"> {{ $title ?? '' }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{$slot}}

                <!-- end container-fluid -->
            </div>
            </div>
            <!-- end wrapper -->

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            © 2019 - {{now('Y')}} Western <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Western V</span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->


        @stack('modals')

         <!-- jQuery  -->
         <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
         <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        {{-- <script src="{{ asset('assets/js/modernizr.min.js')}}"></script> --}}
        {{-- <script src="{{ asset('assets/js/detect.js')}}"></script> --}}
        {{-- <script src="{{ asset('assets/js/fastclick.js')}}"></script> --}}
        <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
        {{-- <script src="{{ asset('assets/js/jquery.blockUI.js')}}"></script> --}}
        <script src="{{ asset('assets/js/waves.js')}}"></script>
        <script src="{{ asset('assets/js/wow.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js')}}"></script>

        <!--Morris Chart-->
        <script src="{{ asset('assets/plugins/morris/morris.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/raphael/raphael.min.js')}}"></script>

        <!-- KNOB JS -->
        {{-- <script src="{{ asset('assets/plugins/jquery-knob/excanvas.js')}}"></script> --}}
        {{-- <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js')}}"></script> --}}
    
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.min.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.resize.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.pie.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.selection.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.stack.js')}}"></script>
            <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.crosshair.js')}}"></script>

        {{-- <script src="{{ asset('assets/pages/dashboard.js')}}"></script> --}}


        <script src="{{ asset('assets/js/app.js')}}"></script>
        @yield('scripts')
        @livewireScripts
    </body>
</html>
