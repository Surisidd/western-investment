<x-app-layout>
    <x-slot name="title">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href=" {{route('contacts.show',$contact->ContactID)}}
        ">{{$contact->full_name}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">All Portfolios</li>
        </ol>
        </nav>

    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-body" style="font-family: Consolas, monaco, monospace">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="text-center">
                                <div class="d-flex justify-content-center ">
                                    <p class="h4 text-center"> {{$contact->full_name}} </p>
                                </div>
                                <div class="d-flex justify-content-center m-2">
                                    <form class="form-horizontal"
                                        action=" {{route('contacts.consolidated',$contact->ContactID)}}" method="GET">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">From</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="startDate" value="{{ date('Y-m-d', strtotime($startDate)) }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">To</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="inputPassword6" class="form-control"
                                                    name="endDate" value="{{ date('Y-m-d', strtotime($endDate)) }}">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary" type="submit">Generate </button>
                                            </div>
                                        </div>


                                    </form>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="border  rounded-sm p-2"
                                        style="background-color: #293F4F;font-size: 15px;">
                                        <p class="h4 text-uppercase font-weight-bold text-white">Monthly Statement</p>
                                        <p class="text-uppercase text-white">
                                            {{ date('F Y', strtotime($endDate)) }}</p>
                                    </div>
                                </div>

                                <hr>
                            </div>

                        <div class="text-center">
                            <h3 class="text-uppercase">Consolidated Portfolio Summary</h3>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-auto">

                    <table class="table table-responsive">

                        <table class="table">

                            <tbody>
                                <tr>
                                    <td>Portfolio Value On {{ $startDate}}:
                                    </td>
                                    <td class="text-right" style="font-weight: bold">
                                        {{number_format((float)$summaryKES["totalStartValueKES"],2,'.',',')}}
                                    </td>
                                </tr>
                                <tr>

                                    <td>Contributions:</td>
                                    <td class="text-right" style="font-weight: bold">
                                            {{ number_format((float)$summaryKES["totalContributionsKES"],2,'.',',')}}</td>

                                </tr>
                                <tr>

                                    <td>Withdrawals:</td>
                                    <td class="text-right" style="font-weight: bold">
                                        {{ number_format((float)$summaryKES["totalWithdrawalsKES"],2,'.',',')}}
                                    </td>

                                </tr>
                                <tr>
                                    <td>Accrued Interest: </td>
                                    <td class="text-right" style="font-weight: bold">
                                        {{ number_format((float)$summaryKES["interestKES"],2,'.',',')}}</td>
                                </tr>

                                <tr>

                                    <td>Portfolio Value On {{$endDate}}:</td>
                                    <td class="text-right" style="font-weight: bold">

                                        {{number_format(intval(($summaryKES["totalEndValueKES"]*100))/100,2)}}

                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @foreach ($mutualfunds as $mutualfund)

                        <div class="card-header text-center">
                            <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                
                                    <table class="table table-responsive">
                
                                        <table class="table">
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                   <h4>
                                                    {{$mutualfund->FullName}}
                                                       </h4> 
                                                </td>
                                            </tr>
                
                                            <tbody>
                                                <tr>
                                                    <td>Portfolio Value On {{ $startDate}}:
                                                    </td>
                                                    <td class="text-right" style="font-weight: bold">
                                                        {{number_format((float)$mutualfund->startValue,2,'.',',')}}
                                                    </td>
                                                </tr>
                                                <tr>
                
                                                    <td>Contributions:</td>
                                                    <td class="text-right" style="font-weight: bold">
                                                            {{ number_format((float)$mutualfund->bought,2,'.',',')}}</td>
                
                                                      
                
                                                </tr>
                                                <tr>
                
                                                    <td>Withdrawals:</td>
                                                    <td class="text-right" style="font-weight: bold">
                                                        {{ number_format((float)$mutualfund->sold,2,'.',',')}}
                                                    </td>
                
                                                </tr>
                                                <tr>
                                                    <td>Accrued Interest: </td>
                                                    <td class="text-right" style="font-weight: bold">
                                                        {{ number_format((float)$mutualfund->interest,2,'.',',')}}</td>
                                                </tr>
                
                                                <tr>
                
                                                    <td>Portfolio Value On {{$endDate}}:</td>
                                                    <td class="text-right" style="font-weight: bold">
                
                                                        {{number_format(intval(($mutualfund->endValue*100))/100,2)}}
                
                                                    </td>
                
                                                </tr>
                
                                            </tbody>
                                        </table>
                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead style="background-color:#87BEDF; color:white">
                                        <tr>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-center"><strong>Security</strong></td>
                                            <td class="text-center"><strong>Unit&nbsp;Cost</strong>
                                            </td>
                                            <td class="text-center"><strong>Total&nbsp;Cost</strong>
                                            </td>
                                            <td class="text-center"><strong>Price</strong>
                                            </td>
                                            <td class="text-center"><strong>Market&nbsp;Value</strong>
                                            </td>
                                            {{-- <td class="text-right"><strong>Pct Assets</strong></td> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                     
                                   
                                      <tr>
                                        <td class="text-center"> {{ number_format((float)$mutualfund->endUnits,2,'.',',')}} </td>

                                        <td class="text-center"> {{$mutualfund->FullName}} </td>
                                        <td class="text-center"> {{ number_format((float)$mutualfund->unitPrice,2,'.',',')}} </td>
                                        <td class="text-center"> {{ number_format((float)$mutualfund->startValue,2,'.',',')}} </td>
                                        <td class="text-center"> {{ number_format((float)$mutualfund->marketPrice,2,'.',',')}} </td>
                
                                        <td class="text-center">{{ number_format((float)$mutualfund->endValue,2,'.',',')}} </td>
                                      </tr>
                                        
                                     




                                      
                                    </tbody>
                                </table>
                                @endforeach

                                @foreach ($fixedincome as $fi)

                                <div class="card-header text-center">
                                    <h5 class="card-title text-dark m-0"><strong>Portfolio&nbsp;Holdings</strong></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                        
                                            <table class="table table-responsive">
                        
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                           <h4>
                                                            {{$fi["FullName"]}}
                                                               </h4> 
                                                        </td>
                                                    </tr>
                        
                                                    <tbody>
                                                        <tr>
                                                            <td>Portfolio Value On {{ $startDate}}:
                                                            </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{number_format((float)$fi["startValue"],2,'.',',')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                        
                                                            <td>Contributions:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                    {{ number_format((float)$fi["bought"],2,'.',',')}}</td>
                        
                                                              
                        
                                                        </tr>
                                                        <tr>
                        
                                                            <td>Withdrawals:</td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float)$fi["sold"],2,'.',',')}}
                                                            </td>
                        
                                                        </tr>
                                                        <tr>
                                                            <td>Accrued Interest: </td>
                                                            <td class="text-right" style="font-weight: bold">
                                                                {{ number_format((float)$fi["interest"],2,'.',',')}}</td>
                                                        </tr>
                        
                                                        <tr>
                        
                                                            <td>Portfolio Value On {{$endDate}}:</td>
                                                            <td class="text-right" style="font-weight: bold">
                        
                                                                {{number_format(intval(($fi["endValue"]*100))/100,2)}}
                        
                                                            </td>
                        
                                                        </tr>
                        
                                                    </tbody>
                                                </table>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead style="background-color:#87BEDF; color:white">
                                                <tr>
                                                    <td class="text-center"><strong>Quantity</strong></td>
                                                    <td class="text-center"><strong>Security</strong></td>
                                                    <td class="text-center"><strong>Unit&nbsp;Cost</strong>
                                                    </td>
                                                    <td class="text-center"><strong>Total&nbsp;Cost</strong>
                                                    </td>
                                                    <td class="text-center"><strong>Price</strong>
                                                    </td>
                                                    <td class="text-center"><strong>Market&nbsp;Value</strong>
                                                    </td>
                                                    {{-- <td class="text-right"><strong>Pct Assets</strong></td> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
        
                                             
                                           
                                              <tr>
                                                <td class="text-center"> --- </td>
        
                                                <td class="text-center"> {{$fi["FullName"]}} </td>
                                                <td class="text-center"> --- </td>
                                                <td class="text-center"> {{ number_format((float)$fi["startValue"],2,'.',',')}} </td>
                                                <td class="text-center"> --- </td>
                        
                                                <td class="text-center">{{ number_format((float)$fi["endValue"],2,'.',',')}} </td>
                                              </tr>
                                                
                                             
        
        
        
        
                                              
                                            </tbody>
                                        </table>
                                        @endforeach
        

                            </div>


                        </div>
                    </div>


                </div>



            </div> <!-- end row -->
        </div> <!-- panel body -->
    </div> <!-- end panel -->

</div> <!-- end col -->

</div>

                               
              
   
    </div>
</x-app-layout>