<x-app-layout>
    <x-slot name="title">
     Password for Account  <a href=" {{route('contacts.show',$contactPassword->ContactID)}} ">{{$contactPassword->contact->full_name}}</a>
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

                 

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="example-email">Current Password</label>
                                <div id="emailHelp" class="form-text" style="font-size:12px"> This is the current
                                    password </div>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" id="example-email" name="email" class="form-control"
                                    value=" {{$contactPassword->password}} "
                                    disabled>
                            </div>
                           
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <div id="emailHelp" class="form-text" style="font-size:12px"> Emails the clients the password </div>
                            </div>
                            <div class="col-sm-4">
                                <form method="POST" action=" {{route('contact.password.send',$contactPassword->ContactID)}}">
                                    @csrf
                                    <button class="btn btn-success" type="submit" >Send Password <i class="fas fa-paper-plane"></i> </button>
                                </form>
                            </div>
                        </div>

                        <hr>

                 

                      <form class="form-horizontal" action=" {{route('contact-password.update',$contactPassword->id)}} "
                        method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <div class="col-sm-2">
                                Reset Password
                                <div id="emailHelp" class="form-text" style="font-size:12px"> This resets the password
                                </div>

                            
                            </div>

                            <div class="col-sm-4">
                                <button class="btn btn-info" type="submit" >Reset Password <i
                                        class="ion ion-md-checkmark-circle-outline"></i> </button>
                            </div>
                           
                        </div>



                    </form>


                    <a class="btn  btn-danger" href="#" data-toggle="tooltip" title="Delete" onclick="if (confirm('Are you sure you want to delete?')) { event.preventDefault();
                        document.getElementById('delete-id-{{$contactPassword->ContactID}}').submit();}">
                        Delete <i class="far fa-trash-alt"></i>
                      </a>
                      <form id="delete-id-{{$contactPassword->contact->ContactID}}" action="{{ route('contacts.password.delete',$contactPassword->ContactID)}}"
                        method="POST" style="display:none">
                        @csrf
        
                      </form>






                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div>

</x-app-layout>