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
   Archives for {{date('F-Y', strtotime('-1 months'))}}
   <hr>

@if (count($files)>0)
<a href=" {{route('archives.download')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6" >Download All&nbsp;<span><i class="far fa-file-archive"></i></span></a>

@endif
 
<hr>
<a href=" {{route('archives.generate')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6" >Generate Statements&nbsp;<span><i class="fas fa-cogs"></i></span></a>



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
                    <th scope="col" >Action</th>
                   
                  </tr>
                </thead>
                <tbody>
                  @foreach ($files as $file)

                  <th scope="row"> {{$loop->iteration}} </th>
                  <td>
                    {{basename($file)}}
                  </td>
                  <td>
                      <a href=" {{route('archives.download.file',basename($file))}} " class="btn btn-success"><i class="fas fa-download"></i></a> 
                  </td>
                 
  
                
  
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