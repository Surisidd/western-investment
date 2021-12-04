<x-app-layout>
    <x-slot name="title">
        All Contacts With Defined Currency
        
  
     {{-- <a href=" {{route('contacts.missing.password')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6" >  Contacts without Passwords <span><i class="fas fa-arrow-circle-right"></i></span></a> --}}

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
                   <div class="float-right m-3">
                    <a href=" {{ route('contactcurrency.create') }} " class="btn btn-sm btn-info"  disabled>
                        Create <i class="ion ion-md-add-circle-outline"></i>
                    </a>
                </div>
           
                <div class="card-body">

     <x-alert></x-alert>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                        <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Currency</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td> {{$contact->contact->full_name}} </td>
                                <td> {{ $contact->currency }} </td>
                                <td class="text-center">
                                    <a href=" {{route('contactcurrency.edit', $contact->ContactID)}} " class="btn btn-primary btn-sm " tabindex="-1" role="button" ><i class="far fa-edit"></i>Edit</a>
                                    <a class="btn  btn-danger" href="#" data-toggle="tooltip" title="Delete" onclick="if (confirm('Are you sure you want to delete?')) { event.preventDefault();
                                        document.getElementById('delete-id-{{$contact->ContactID}}').submit();}">
                                        Delete <i class="far fa-trash-alt"></i>
                                      </a>
                                      <form id="delete-id-{{$contact->ContactID}}" action="{{ route('contactcurrency.destroy',$contact->ContactID)}}"   method="POST" style="display:none">
                                        @method("DELETE")
                                        @csrf

                    
                                      </form>
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
