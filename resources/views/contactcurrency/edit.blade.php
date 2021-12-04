<x-app-layout>

    <x-slot name="title">
        <a href="">
            <div class="">
                <a href=" {{route('contactcurrency.index')}} " role="button"  class="h6" data-bs-toggle="button" style="color:#6ACDE6;font-size:12px" ><span><i class="fas fa-arrow-circle-left"></i></span> All  </a>
                   </div> 
             {{$contact->full_name}} <i class="fas fa-chevron-right"></i></a>&nbsp;Currency&nbsp; <i class="fas fa-money-bill-alt"></i><br>
        <small>Select Specific Preferred Currency for the client for monthly statements</small>
    </x-slot>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" style="background-color:white">

                    <form class="form-horizontal" action=" {{route('contactcurrency.update',$contact->ContactID)}} " method="POST">
                        @csrf
                        @method('PATCH')
                    
                        <div class="form-group row">
                    
                        </div>
                      
                        <hr>
                    
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="example-password-input">Currency</label>

                                <select class="form-control" name="currency" required data-live-search="true">
                                   
                                    <option value="usd">From KES to  USD (USD Funds)
                                     </option>
                                     <option value="kes">From USD to  KES (USD Funds)
                                    </option>
                                    
                                </select>
                            </div>
                        </div>

                        <hr>

                     
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-md-8 float-end">
                                <button type="submit" class="btn btn-success">Update <i
                                        class="ion ion-md-save"></i></button>

                            </div>
                        </div>





                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- End row -->

</x-app-layout>