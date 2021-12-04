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
    Name: {{$schedule->name}}

  </x-slot>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4> Dispatch Date : {{$schedule->dispatch_date}} </h4>
          <h4> Repeat : {{$schedule->frequency}} </h4>

          @if ($schedule->status === "pending")
          <span class="badge bg-warning" style="color: white">Pending</span>

          @elseif($schedule->status === "rejected")
          <span class="badge bg-danger" style="color: white">Rejected</span>
          @elseif($schedule->status==="approved")
          <span class="badge bg-success" style="color: white">Approved</span>

          <h4>Approved By: {{ $schedule->approver->name }}</h4>
          <h4>Last Dispatch Date:
            {{$schedule->emails()->count()>0 ? $schedule->emails()->latest()->first()->created_at->diffForHumans() :"Not yet"}}
          </h4>
          <a href=" {{route('schedule.summary',$schedule->id)}} " role="button" class="h6" data-bs-toggle="button"
            style="color:#97e66a;"> Summary <span><i class="fas fa-chart-line"></i></span></a>

          @endif
          <div class="row">

            <div class="float-right m-3">
              @if (Auth::user()->id === $schedule->user_id)
              @if ($schedule->status === "pending" || $schedule->status === "rejected" )
              <a href=" {{ route('schedule.addcontacts',$schedule->id) }} " class="btn btn-sm btn-info">
                Add Contacts <i class="ion ion-md-add-circle-outline"></i>
              </a>
              @endif
              @admin
              <a class="btn  btn-dark" href="#" data-toggle="tooltip" title="Delete" onclick="if (confirm('Are you sure you want to delete?')) { event.preventDefault();
                document.getElementById('delete-id-{{$schedule->id}}').submit();}">
                Delete <i class="far fa-trash-alt"></i>
              </a>
              <form id="delete-id-{{$schedule->id}}" action="{{ route('schedule.delete',$schedule->id)}}"
                method="POST" style="display:none">
                @csrf

              </form>

              @endadmin

              @endif

           

              @admin
              @if ($schedule->status==="pending")
              <a class="btn  btn-success" href="#" data-toggle="tooltip" title="Aprove" onclick="if (confirm('Are you sure?')) { event.preventDefault();
                                              document.getElementById('approve-id-{{$schedule->id}}').submit();}">
                Approve <i class="far fa-check-circle"></i>
              </a>
              <form id="approve-id-{{$schedule->id}}" action="{{ route('schedule.approve',$schedule->id)}}"
                method="POST" style="display:none">
                @csrf

              </form>

              <a class="btn btn-danger " href="#" data-toggle="tooltip" title="Reject" onclick="if (confirm('Are you sure?')) { event.preventDefault();
                                              document.getElementById('reject-id-{{$schedule->id}}').submit();}">
                Reject <i class="fa fa-fw fa-times "></i>
              </a>
              <form id="reject-id-{{$schedule->id}}" action="{{ route('schedule.reject',$schedule->id)}}" method="POST"
                style="display:none">
                @csrf

              </form>
              @else

              @endif

              @endadmin

            </div>
            <div class="col-lg-12 col-sm-12 col-12">
              <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; width: 100%;">

                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Added On</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($schedule->contactSchedules as $contact)

                  <th scope="row"> {{$loop->iteration}} </th>
                  <td>
                    {{$contact->contact->full_name}}

                  </td>
                  <td>
                    {{$contact->contact->Email}}

                  </td>

                  <td class="text-center"> {{$contact->created_at->diffForHumans()}} </td>
                  <td class="text-center">
                    <a href=" {{route('contacts.show', $contact->ContactID)}} " class="btn btn-primary btn-sm "
                      tabindex="-1" role="button"><i class="ion ion-md-eye"></i></a>
                    <a class="btn btn-sm btn-alt-success" href="#" data-toggle="tooltip" title="Delete"
                      onclick="if (confirm('Are you sure?')) { event.preventDefault();
                                                                   document.getElementById('contactSchedules-id-{{$contact->id}}').submit();}">
                      <i class="fa fa-fw fa-times text-danger"></i>
                    </a>
                    <form id="contactSchedules-id-{{$contact->id}}"
                      action="{{ route('contactschedules.destroy',$contact->id)}}" method="POST" style="display:none">
                      @csrf
                      @method('DELETE')
                    </form>
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