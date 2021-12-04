<x-app-layout>

    <x-slot name="title">
        Create Schedule <i class="fas fa-calendar-alt"></i><br>
        <small>Schedule for sending client statetments for the previous month</small>
    </x-slot>
    <x-jet-validation-errors class="mb-4" />

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" style="background-color:white">

                    <form class="form-horizontal" action=" {{route('schedule.store')}} " method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-4 ">
                                <label class="control-label" for="example-text-input">Name</label>
                                <div id="emailHelp" class="form-text" style="font-size:12px">Use Descriptive Name </div>
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="example-text-input">Name</label>

                                <input type="text" class="form-control" name="name" id="example-text-input"
                                    value=" {{old('name')}} ">

                            </div>

                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-sm-4">
                                Clients

                                <div id="emailHelp" class="form-text" style="font-size:12px"> Here you can select as
                                    many clients for your schedule as possible, you can search as well
                                </div>
                            </div>
                            <div class="col-sm-8">

                                <label class="control-label">Clients</label>

                                <select class="selectpicker form-control" data-live-search="true" multiple
                                    name="clients[]">
                                    @foreach ($clients as $client)
                                    <option value=" {{$client->ContactID}} "> {{$client->full_name}} -
                                        {{$client->ContactCode}} </option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                Date & Time
                                <div id="emailHelp" class="form-text" style="font-size:12px"> Here you can set the date
                                    the schedule should start, the dispatch date must be a date after tomorrow
                                </div>

                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="example-text-input">Dispatch Date</label>

                                <input type="date" class="form-control" name="dispatch_date" id="example-text-input"
                                    min=" {{now()->format('Y-m-d')}} " value=" {{old('dispatch_date')}} ">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="example-password-input">Repeat</label>

                                <select class="form-control" name="frequency" required>
                                    <option value="hourly">Every Hour</option>
                                    <option value="weekly">Every Week (Monday)</option>
                                    <option value="monthly">Every 4th day of Every Month</option>
                                    <option value="quarterly">Quarterly (first day of every quarter at 00:00)</option>
                                    <option value="">Last Day of the Month</option>
                                </select>
                            </div>
                        </div>


                        <hr>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                Description
                                <div id="emailHelp" class="form-text" style="font-size:12px">
                                    Here you can add a description to the schedule.

                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="example-textarea-input">Description</label>

                                <textarea class="form-control" rows="4" id="example-textarea-input"
                                    name="desc"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-md-8 float-end">
                                <button type="submit" class="btn btn-success">Create <i
                                        class="ion ion-md-save"></i></button>

                            </div>
                        </div>





                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- End row -->

</x-app-layout>