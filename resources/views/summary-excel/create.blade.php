<x-app-layout>
    <x-slot name="title">
        Import Data

        <a href=" {{route('allimported')}} ">
        All Imported Contacts
        </a>
    </x-slot>
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
    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
               Import  Client Summary data
            </div>
            <div class="card-body">
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">Import User Data</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>