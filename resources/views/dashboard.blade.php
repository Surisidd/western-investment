<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="small-box bg-success" style="border-radius: 5px" >
                <div class="inner p-2">
                  <h3 style="color: white"> {{$totals->sent}} </h3>
  
                  <p style="color: white">{{\Str::plural('Email',$totals->sent)}} Sent this Month</p>
                </div>
               
                <a href="#" class="small-box-footer" style="    background-color: rgba(0,0,0,.1);
                color: rgba(255,255,255,.8);
                display: block;
                padding: 3px 0;
                position: relative;
                text-align: center;
                text-decoration: none;
                z-index: 10;">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="small-box bg-info" style="border-radius: 5px" >
                <div class="inner p-2">
                  <h3> {{$totals->failed}} </h3>
  
                  <p>Failed {{\Str::plural('Email',$totals->failed)}} </p>
                </div>
               
                <a href=" {{route('emails.failed')}} " class="small-box-footer" style="    background-color: rgba(0,0,0,.1);
                color: rgba(255,255,255,.8);
                display: block;
                padding: 3px 0;
                position: relative;
                text-align: center;
                text-decoration: none;
                z-index: 10;">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="small-box bg-info" style="border-radius: 5px" >
                <div class="inner p-2">
                  <h3> {{$totals->sent}} </h3>
  
                  <p>{{\Str::plural('Email',$totals->sent)}} Sent This Month</p>
                </div>
               
                <a href=" {{route("emails.thismonth")}} " class="small-box-footer" style="    background-color: rgba(0,0,0,.1);
                color: rgba(255,255,255,.8);
                display: block;
                padding: 3px 0;
                position: relative;
                text-align: center;
                text-decoration: none;
                z-index: 10;">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="small-box bg-info" style="border-radius: 5px" >
                <div class="inner p-2">
                  <h3> {{$totalusers}} </h3>
  
                  <p>Total Contacts</p>
                </div>
               
                <a href=" {{route('contacts.index')}} " class="small-box-footer" style="    background-color: rgba(0,0,0,.1);
                color: rgba(255,255,255,.8);
                display: block;
                padding: 3px 0;
                position: relative;
                text-align: center;
                text-decoration: none;
                z-index: 10;">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
        </div>

     
    </div>

    {{-- Recent Emails Sent --}}
    <div class="row mt-2">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="m-b-30 m-t-0">Recent Emails Sent</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Contact Name</th>
                                        <th scope="col">Sent By</th>
                                        <th scope="col">Sent On</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @forelse ($emails as $email)
                                      <tr>
                                        <th scope="row"> {{$loop->iteration}} </th>
                                        <td> {{$email->contact ? $email->contact->full_name:"Null" }} </td>
                                        <td> <small>{{$email->user ? $email->user->name:"System/Scheduled"}}</small> </td>
                                        <td> {{$email->created_at->diffForHumans()}} </td>
                                      </tr>
                                      @empty
                                          <tr>
                                            <td colspan="4" class="text-center">No Emails Sent</td>
                                          </tr>
                                      @endforelse
                                                                                                          
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="m-b-30 m-t-0">List of Recent Contacts</h4>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                
                                    <th scope="col">Name</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                    <tr>
                                        <th scope="row"> {{$loop->iteration}} </th>
                                    
                                        <td> {{$user->FirstName}} {{$user->LastName}} </td>
                                        <td ><a href=" {{route('contacts.show',$user->ContactID)}} "> <i class="fas fa-arrow-circle-right ml-4 fa-lg"></i></a> </td>
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
        
    </div>
    <!-- end row -->

   

     
        <!-- end row -->

    {{-- </div> --}}
</x-app-layout>
