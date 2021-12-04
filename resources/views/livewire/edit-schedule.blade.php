<div>
    <x-slot name="title">
        Statement Sending  Schedule
        
    </x-slot>
    <p><u>{{$schedule->name}}</u></p>
    <div class="row">
    <table class="table">
      <div class="float-right m-3">
        <a href=" {{ route('client.create') }} " class="btn btn-sm btn-info">
            Add Contacts  <i class="ion ion-md-add-circle-outline"></i>
        </a>
      
      
         <!-- Modal -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
 
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Save Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @livewire('post-form') --}}
                </div>            
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalShowPhotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Additional Photos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @livewire('post-additional-photos') --}}
                </div>            
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalFormDelete" tabindex="-1" aria-labelledby="modalFormDeletePost" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormDeletePost">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Do you wish to continue?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button wire:click="delete" type="button" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
    </div>

       
     
    </div>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th>Portfolios</th>
            <th scope="col" class="text-center">Added On</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>


            @forelse ($schedule->contactSchedules as $contact)
            <tr>
                <th scope="row"> {{$loop->iteration}} </th>
                <td> {{$contact->contact->full_name}} </td>
                <td> {{$contact->contact->portfolios->count()}} </td>

                <td class="text-center">  {{$contact->created_at->diffForHumans()}} </td>
                <td class="text-center">

                    <button wire:click="selectItem({{ $contact->id }}, 'update')" class="btn btn-sm btn-success">Update</button>
                    <button wire:click="selectItem({{ $contact->id }}, 'delete')" class="btn btn-sm btn-danger">Delete</button>
                  {{-- <a href=" {{route('contacts.show', $contact->ContactID)}} " class="btn btn-primary btn-sm " tabindex="-1" role="button" ><i class="ion ion-md-eye"></i></a>
                  <a  class="btn btn-sm btn-alt-success" href="#" data-toggle="tooltip" title="Delete"
                                 onclick="if (confirm('Are you sure?')) { event.preventDefault();
                                     document.getElementById('contactSchedules-id-{{$contact->id}}').submit();}">
                                     <i class="fa fa-fw fa-times text-danger"></i>
                                 </a>
                                 <form id="contactSchedules-id-{{$contact->id}}" action="{{ route('contactschedules.destroy',$contact->id)}}" method="POST" style="display:none">
                                     @csrf
                                     @method('DELETE')
                                 </form> --}}
              </td>
              </tr>
            @empty
                  <tr>
                    <td colspan="5" class="text-center"> 
                      <div class="alert alert-info" role="alert">
                        No Contacts on this Schedule
                      </div>
                    </td>
                  </tr>
            @endforelse
       
        
      
        </tbody>
      </table>
</div>
</div>

<script>
      window.addEventListener('closeModal', event => {
                $("#modalForm").modal('hide');                
            })

            window.addEventListener('openModal', event => {
                $("#modalForm").modal('show');
            })

            window.addEventListener('openDeleteModal', event => {
                $("#modalFormDelete").modal('show');
            })

            window.addEventListener('closeDeleteModal', event => {
                $("#modalFormDelete").modal('hide');
            })  

            // Opens the show photos modal
            window.addEventListener('openModalShowPhotos', event => {
                $("#modalShowPhotos").modal('show');
            })
            
            $(document).ready(function(){        
                // This event is triggered when the modal is hidden       
                $("#modalForm").on('hidden.bs.modal', function(){
                    livewire.emit('forcedCloseModal');
                });
            });    
</script>

