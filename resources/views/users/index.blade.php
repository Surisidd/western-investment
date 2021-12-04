<x-app-layout>
    <x-slot name="title">
        All users
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
                    <a href=" {{ route('user.create') }} " class="btn btn-sm btn-info">
                        Create <i class="ion ion-md-add-circle-outline"></i>
                    </a>
                </div>
                <div class="card-body">

     <x-alert></x-alert>
     <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
     style="border-collapse: collapse; width: 100%;">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Date Added</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td> 
                                    @if ($user->roles->count()>0)
                                    @foreach ($user->roles as $role)
                                        {{$role->name}}
                                    @endforeach
                                    @else
                                        No Role Attached
                                    @endif
                                 </td>
                                <td>{{$user->email}}</td>

                                <td> {{$user->created_at->diffForHumans()}} </td>
                                <td class="text-center">
                                    {{-- <button type="button" class="btn btn-primary btn-sm"> <i class="ion ion-md-eye"></i></button> --}}
                                    <a href=" {{route('user.edit', $user->id)}} " class="btn btn-info btn-sm " tabindex="-1" role="button" ><i class="ion ion-md-create"></i></a>
                                    <a  class="btn btn-sm btn-success" href="#" data-toggle="tooltip" title="Delete"
                                    onclick="if (confirm('Are you sure?')) { event.preventDefault();
                                        document.getElementById('user-id-{{$user->id}}').submit();}">
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                    </a>
                                    <form id="user-id-{{$user->id}}" action="{{ route('user.destroy',$user->id)}}" method="POST" style="display:none">
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

    </div> <!-- End Row -->
</x-app-layout>
