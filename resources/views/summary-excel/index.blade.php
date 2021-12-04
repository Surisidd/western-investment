<x-app-layout>
    <x-slot name="title">
        All Contacts
    </x-slot>
    <br>
    <a href=" {{ route('create.import') }} " class="btn btn-success">
        Import
    </a>
    @section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/fixedHeader.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
       
   @endsection
   @section('scripts')
     <!-- Required datatable js-->
     <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
     <!-- Buttons examples -->
     <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
     
     <script src="{{ asset('assets/plugins/datatables/jszip.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
     <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
     <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
     <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>

     <!-- Responsive examples -->
     <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
     <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

     <!-- Datatable init js -->
     <script src="{{ asset('assets/pages/datatables.init.js')}}"></script>
       
   @endsection
  
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="float-right m-3">
                    <a href=" {{ route('client.create') }} " class="btn btn-sm btn-info"  disabled>
                        Create <i class="ion ion-md-add-circle-outline"></i>
                    </a>
                </div> --}}
                <div class="card-body">

                    <x-alert></x-alert>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Fund</th>
                                <th>Start Value</th>
                                <th>Contributions</th>
                                <th>Withdrawals</th>
                                <th>Return</th>
                                <th>Last Value</th>
                                <th>Email</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->client }} </td>
                                    <td>{{ $client->fund }} </td>
                                    <td> {{ $client->startValue }} </td>
                                    <td> {{ $client->contributions }} </td>
                                    <td> {{ $client->redemption }} </td>
                                    <td> {{ $client->return }} </td>
                                    <td> {{ $client->endValue }} </td>
                                    <td> {{ $client->email1 }} </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div> <!-- End Row -->
</x-app-layout>
