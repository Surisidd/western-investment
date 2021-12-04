<x-app-layout>

    <x-slot name="title">
        Specify Currency <i class="fas fa-money-bill-alt"></i><br>
        <small>Select Specific Preferred Currency for a contact for monthly statements</small>
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

                    <form class="form-horizontal" action=" {{route('contactcurrency.store')}} " method="POST">
                        @csrf
                        <div class="form-group row">
                    
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-sm-4">
                                Contacts

                                <div id="emailHelp" class="form-text" style="font-size:12px">
                                     Select the contact you will want to specify the currency for monthly statements
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label">Contact</label>
                                <select class="selectpicker form-control" data-live-search="true" multiple
                                    name="contact">
                                    @foreach ($contacts as $contact)
                                    <option value=" {{$contact->ContactID}} "> {{$contact->full_name}} -
                                        {{$contact->DeliveryName}} </option>
                                    @endforeach
                                </select>


                            </div>
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
                                     <option value="kes">From USD to  KES (USD Funds))
                                    </option>
                                    
                                </select>
                            </div>
                        </div>

                        <hr>

                     
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-md-8 float-end">
                                <button type="submit" class="btn btn-success">Save <i
                                        class="ion ion-md-save"></i></button>

                            </div>
                        </div>


                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- End row -->

</x-app-layout>