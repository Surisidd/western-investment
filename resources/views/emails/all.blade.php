<x-app-layout>

    @section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/fixedHeader.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
      type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
  
    @endsection
    @section('scripts')
    <!-- Required datatable js-->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
  
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>
  
    <!-- Responsive examples -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
  
    <!-- Datatable init js -->
    <script src="{{ asset('assets/pages/datatables.init.js') }}"></script>
  
    @endsection
  
 
    <x-slot name="title">
     All Dispatched Emails
     <hr>
     
     <a href=" {{route('emails.thismonth')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6" >  Emails this Month <span><i class="fas fa-arrow-circle-right"></i></span></a>

    </x-slot>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
           

            <div class="row">
  
            
              <div class="col-lg-12 col-sm-12 col-12">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                  style="border-collapse: collapse; width: 100%;">
  
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col" >Sent to</th>
                      <th scope="col" >Status</th>
                      <th scope="col" >Desc</th>
                      <th scope="col" class="text-center">On</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($emails as $email)
  
                    <th scope="row"> {{$loop->iteration}} </th>
                    <td>
                      {{$email->contact->full_name}}
                    </td>
                    <td>
                        {{$email->email}}
                    </td>
                    <td>
                      {{$email->status}}
                  </td>
                  <td>
                    {{$email->desc}}

                  </td>
    
                    <td class="text-center"> {{$email->created_at->diffForHumans()}} </td>
                    
                    </tr>
                    @endforeach
  
                  </tbody>
                </table>
  
              </div>
            </div>
          </div>
        </div>
      </div>
  
    </div> <!-- End Row -->
  
    {{-- <livewire:edit-schedule :schedule="$schedule"/> --}}
  
  
  </x-app-layout>