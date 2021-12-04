<x-app-layout>
    <x-slot name="title">
        User Registration
    </x-slot>
    <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <div class="card-body">

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                
                <x-jet-validation-errors class="mb-4" />

                  <form class="form-horizontal" action=" {{route('user.store')}} " method="POST">
                    @csrf
                      <div class="form-group row">
                          <label class="col-sm-2 control-label" for="example-text-input">Name</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control"  id="example-text-input" name="name" placeholder="Client Full Name" value=" {{old('name')}} ">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2 control-label" for="example-email">Email</label>
                          <div class="col-sm-10">
                              <input type="email" id="example-email" name="email" class="form-control" placeholder="Email" value=" {{old('email')}} ">
                          </div>
                      </div>
                    
                      <div class="form-group row">
                          <label class="col-sm-2 control-label">Role</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="role">
                               @foreach ($roles as $role)
                                    <option value=" {{$role->id}} "> {{$role->name}} </option>
                               @endforeach
  
                            </select>
                          </div>
             
                      </div>
                      {{-- <div class="form-group row">
                          <label class="col-sm-2 control-label" for="example-textarea-input">Notes</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" rows="5" id="example-textarea-input" name="desc"></textarea>
                          </div>
                      </div> --}}

                      <div class="form-group row">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                          <button class="btn btn-primary" type="submit">Create </button>
                        </div>
                      </div>

                   

                  </form>
              </div> <!-- card-body -->
          </div> <!-- card -->
      </div> <!-- col -->
  </div> 
  
</x-app-layout>
