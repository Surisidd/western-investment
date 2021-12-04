<x-app-layout>
    
    <x-slot name="title">
        Statement Dispatch Schedule
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                <div class="card-body">
                   
                    <form class="form-horizontal" action=" {{route('schedule.addcontacts.save',$schedule->id)}} " method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="example-text-input" value=" {{$schedule->name}} " disabled>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="dispatch_date">Dispatch Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="dispatch_date" id="example-text-input" value="{{ date('Y-m-d', strtotime($schedule->dispatch_date)) }}">
                            </div>
                        </div>
                    
                     
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="example-password-input">Frequency</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="frequency" required>
                                    < value="weekly" {{$schedule->frequency === "weekly" ? 'selected':""}} >Weekly</option>
                                    <option value="monthly" {{$schedule->frequency === "monthly" ? 'selected':""}}>Monthly</option>
                                    <option value="quarterly" {{$schedule->frequency === "quarterly" ? 'selected':""}}>Quarterly</option>
                                    <option value="yearly" {{$schedule->frequency === "yearly" ? 'selected':""}}>Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-2 control-label">Clients</label>
                            <div class="col-sm-10" >
                        
                                <select class="selectpicker form-control" data-live-search="true" multiple name="clients[]">
                                   @foreach ($clients as $client)
                                      <option value=" {{$client->ContactID}} " 
                                        @foreach($schedule->contactSchedules as $contact) @if($client->ContactID === $contact->ContactID) selected="selected"@endif @endforeach
                                        > {{$client->FirstName && $client->LastName ? $client->full_name:$client->ContactName }}</option>                                       
                                   @endforeach
                                  </select>
                                  
                                  
                            </div>
                        </div>
                       
                    
                   
                      <hr>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-success">Update <i class="ion ion-md-save"></i></button>

                            </div>
                        </div>

                    

              

                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- End row -->
  
</x-app-layout>
