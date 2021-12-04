<x-app-layout>
    <x-slot name="title">
        <div class="">
            <a href=" {{route('schedule.index')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" ><span><i class="fas fa-arrow-circle-left"></i></span> All Schedules </a>
               </div> 
               <hr>  
               {{$schedule->name}} ({{$schedule->contactSchedules->count()}} Clients)
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-success">Unique Clients Emailed this month</div>
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <p style="font-family: Consolas, monaco, monospace"> {{$totals->sent}}/{{$totals->total}} <br>
                            <a href=" {{route('schedule.sent',$schedule->id)}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" >View <span><i class="fas fa-arrow-circle-right"></i></span> </a>

                        </p>
                       
                        <footer class="blockquote-footer"> <cite title="Last Time ">{{$schedule->created_at->format("F j, Y, g:i a")}}</cite></footer>
    
                                    </blockquote>
                </div>
            </div>
            
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-danger">Unique Clients Emails Failed this month</div>
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <p style="font-family: Consolas, monaco, monospace"> {{$totals->failed}}/{{$totals->total}} 
                        <br>
                        <a href=" {{route('schedule.failed',$schedule->id)}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" >View <span><i class="fas fa-arrow-circle-right"></i></span> </a>

                    </p>
                       
                        <footer class="blockquote-footer"> <cite title="Last Time ">{{$schedule->created_at->format("F j, Y, g:i a")}}</cite></footer>
    
                
            
                    </blockquote>
                </div>
            </div>
            
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-info">Fund Value Dispatched</div>
                <div class="card-body">
                    <blockquote class="card-bodyquote">
                        <p style="font-family: Consolas, monaco, monospace"> {{$valueThisMonth}} </p>
                       
                        <footer class="blockquote-footer"> <cite title="Last Time ">{{$schedule->created_at->format("F j, Y, g:i a")}}</cite></footer>
    
                    
                    </blockquote>
                </div>
            </div>
            
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-secondary">Total Emails Sent</div>
                <div class="card-body">
                  
                 
                    <blockquote class="card-bodyquote">
                        <p style="font-family: Consolas, monaco, monospace"> {{$totals->totalAll}} </p>
                       
                        <footer class="blockquote-footer"> <cite title="Last Time ">{{$schedule->created_at->format("F j, Y, g:i a")}}</cite></footer>
                        <cite>*Includes RMs</cite>
                    </blockquote>
                </div>
            </div>
            
        </div>
    </div>
   
</x-app-layout>