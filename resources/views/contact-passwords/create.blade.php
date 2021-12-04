<x-app-layout>
    <x-slot name="title">
        Creating Password for  {{$contact->full_name}}
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

                    <form class="form-horizontal" action=" {{route('contact-password.create.password.save',$contact->ContactID)}} "
                        method="POST">
                        @csrf



                    
                        

                        {{-- <div class="form-group row">
                          <label class="col-sm-2 control-label" for="example-textarea-input">Notes</label>
                          <div class="col-sm-10">
                              <textarea class="form-control" rows="5" id="example-textarea-input" name="desc"></textarea>
                          </div>
                      </div> --}}

                        <div class="form-group row">
                            <div class="col-sm-2">
                                Generate Password
                                <div id="emailHelp" class="form-text" style="font-size:12px"> Generates Passwords 
                                </div>

                            </div>

                            <div class="col-sm-10">
                                <button class="btn btn-info" type="submit">Generate Password <i
                                        class="ion ion-md-checkmark-circle-outline"></i> </button>
                            </div>
                        </div>



                    </form>



                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div>

</x-app-layout>