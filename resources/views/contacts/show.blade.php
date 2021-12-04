<x-app-layout>
    <x-slot name="title">

       <div class="ml-3">
        <a href=" {{route('contacts.index')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" ><span><i class="fas fa-arrow-circle-left"></i></span> All Contacts </a>
           </div> 

       <div class="ml-3">{{$contact->full_name}}, {{$contact->ReportHeading2 }}</div> 
    </x-slot>
    <div class="col-lg-12">
        <div>
            <x-alert></x-alert>
        </div>
        <div class="row ">
            <div class="col-sm-4">

                <table class="table table-responsive">

                    <table class="table">

                        <tbody>
                            <tr>

                                <td>Name :  
                                </td>
                                <td class="text-right" style="font-weight: bold">
                                    {{ trim($contact->full_name) }}
                                </td>
                            </tr>
                            <tr>

                                <td>Email: 

                                </td>
                                <td class="text-right" style="font-weight: bold">
                                    {{$contact->Email}}
                                </td>

                            </tr>
                            <tr>

                                <td>ID/Passport: 

                                </td>
                                <td class="text-right" style="font-weight: bold">
                                    {{$contact->NationalID}}
                                </td>

                            </tr>
                            <tr>
                                <td>Email:  </td>
                                <td class="text-right" style="font-weight: bold">
                                    {{$contact->Email}} 
                                    </td>
                            </tr>

                            <tr>
                                <td>Other Emails:</td>
                                <td class="text-right" style="font-weight: bold">
                                         {{$contact->Email2}} {{$contact->Email3}}
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td class="text-right" style="font-weight: bold">
                                         {{$contact->BusinessPhone}}
                                </td>
                            </tr>

                            <tr>
                                <td>Password:</td>
                                <td class="text-left" style="font-weight: bold">

                                    @if (@empty($contact->contactPassword))
                                    <span class="badge bg-success" style="color: white;font-size:12px">Uses&nbsp;ID/Passport</span><a href=" {{ route('contact-password.create.password',$contact->ContactID)}} ">Create&nbsp;One</a>

                                    @else
                                       <span class="badge bg-success" style="color: white;font-size:12px">&nbsp;Uses Custom Password  </span> <a href=" {{route('contact-password.edit',$contact->contactPassword->id)}} ">View</a>
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <td>Consolidated&nbsp;Statement</td>
                                <td class="text-right" style="font-weight: bold">
                        
                                    <span class="badge " style="color: ;font-size:">  </span> <a href=" {{ route('contacts.consolidated',$contact->ContactID)}} "> View <i class="fas fa-arrow-circle-right"></i> </a>

    
                                </td>
                            </tr>
                            <tr>
                                <td>Schedule&nbsp;Assigned</td>
                                <td class="text-right" style="font-weight: bold">

                                   @if (@empty($contact->contactSchedule))
                                        <span>
                                            No schedule for this client
                                        </span>

                                   @else
                                    <span class="badge " style="color: ;font-size:">  </span> <a href=" {{ route('schedule.show',$contact->contactSchedule->schedule->id)}} "> {{$contact->contactSchedule->schedule->name}} <i class="fas fa-arrow-circle-right"></i> </a>

                                   @endif

                    
    
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a href=" {{ route('test.contacts.summary',$contact->ContactID)}} ">Consolidated&nbsp;(Test<span>&nbsp;&#128064;</span>
                                        )</a>
                                </td>
                            </tr>

                           

                        </tbody>
                    </table>
                </table>



                
            </div>
<div class="col-sm-1">

</div>
        <div class="col-sm-6">
            <table class="table table-striped">
                <h4 >&nbsp;<u>Portfolios</u></h4>

                <thead>
                    <tr>
                      <th scope="col">Report&nbsp;Heading</th>
                      <th scope="col">Porfolio&nbsp;Code</th>
                      <th scope="col">Porfolio&nbsp;Status</th>

                      <th class="text-center"  scope="col">Action</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                @forelse ($contact->portfolios as $portfolio)
                    <tr>
                        <td> {{$portfolio->ReportHeading1}} </td>
                        <td> {{$portfolio->PortfolioCode}} </td>
                        <td> {{$portfolio->PortfolioStatus}} </td>

                        <td class="text-center"> 
                            <a href=" {{route('contacts.portfolio',$portfolio->PortfolioID)}} " class="btn btn-outline-primary">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                        </td>
                    
                    </tr>
                @empty
                    No Portfolios For this Client
                @endforelse
    
               
                      
    
                  </tbody>
              </table>

        </div>
      
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-8">
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
                                            {{-- <th scope="col">Contact Name</th> --}}
                                            <th scope="col">Sent By</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Sent On</th>
                                          </tr>
                                        </thead>
                                        <tbody>
    
                                          @forelse ($emails as $email)
                                          <tr>
                                            <th scope="row"> {{$loop->iteration}} </th>
                                            {{-- <td> {{$email->contact->full_name}} </td> --}}
                                            <td> <small>{{$email->user()->exists() ? $email->user->name:"System/Scheduled"}}</small> </td>
                                            <td> {{$email->email}} </td>
                                            <td> {{$email->status}} </td>


                                            <td> {{$email->created_at->diffForHumans()}} </td>
                                          </tr>
                                          @empty
                                              <tr>
                                                <td colspan="6" class="text-center">No Emails Sent yet</td>
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
            <div class="col-lg-4">

                    <h5>Bank Details</h5>
                    <p class="text-left" style="font-weight: bold">
                             {{ trim($contact->BankDetails)}}

                             {{-- {{preg_replace('/\s+/', '', $contact->BankDetails)}} --}}

                    </p>
            </div>
        </div>
       

    </div>

</x-app-layout>