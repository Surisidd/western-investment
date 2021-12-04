<x-app-layout>
    <x-slot name="title">
        <a href=" {{route('contact-password.index')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" ><span><i class="fas fa-arrow-circle-left"></i></span>  All </a>
        <hr class="mt-1 mb-2">
        Contacts without Passwords <br>
        <div class="float-left mt-2 mb-1">
            <a href=" {{ route('contacts.missing.password.send') }} " class="btn btn-sm btn-info">
                Generate Passwords for All <i class="ion ion-md-add-circle-outline"></i>
            </a>
        </div>
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
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
             
           
                <div class="card-body">

     <x-alert></x-alert>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                        <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Email</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td> {{$contact->full_name}} </td>
                                <td> {{$contact->Email}} </td>

                                <td class="text-center">
                                    <a href=" {{ route('contact-password.create.password',$contact->ContactID)}} " class="btn btn-primary btn-sm " tabindex="-1" role="button" >Create <i class="fas fa-plus-circle"></i></a>
                                </td>
                             
                            </tr>
                            @endforeach
                        
                    
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div> <!-- End Row -->
</x-app-layout>
