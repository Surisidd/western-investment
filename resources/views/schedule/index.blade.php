<x-app-layout>
    <x-slot name="title">
        All Schedules
    </x-slot>
    @section('css')
        <!-- DataTables -->
        <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/fixedHeader.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />

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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

               
                <div class="float-right m-3">
                    <a href=" {{ route('schedule.create') }} " class="btn btn-sm btn-info">
                        Create <i class="ion ion-md-add-circle-outline"></i>
                    </a>
                    <hr>                    
                    <a href=" {{route('schedule.missing.contacts')}} " role="button"  class="h6 mt-1" data-bs-toggle="button" style="color:#6ACDE6" > Missing Contacts <span><i class="fas fa-arrow-circle-right"></i></span></a>

                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Frequency</th>
                                        <th>Total Clients</th>
                                        <th>Status</th>
                                        <th>Desc</th>
                                        <th>Created On</th>
                                        <th align="center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td> {{ $schedule->name }} </td>
                                            <td> {{ $schedule->frequency }} </td>
                                            <td> {{$schedule->contactSchedules->count()}} <a href=" {{route('schedule.show',$schedule->id)}} "> <i class="fas fa-users"></i></a> </td>
                                            <td>

                                                @if ($schedule->status === "pending")
                                                <span class="badge bg-warning" style="color: white">Pending</span>

                                                @elseif($schedule->status === "rejected")
                                                <span class="badge bg-danger" style="color: white">Rejected</span>
                                                @elseif($schedule->status==="approved")
                                                <span class="badge bg-success" style="color: white">Approved</span>
                                                @endif
                                            </td>

                                            <td>{{ $schedule->desc }}</td>
                                            <td> {{ $schedule->created_at->diffForHumans() }} </td>
                                            <td>
                                                <a href=" {{ route('schedule.show', $schedule->id) }} "
                                                    class="btn btn-outline-info" s>View <i
                                                        class="ion ion-md-arrow-round-forward"></i></a>
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

    </div>
</x-app-layout>
