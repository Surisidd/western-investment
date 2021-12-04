<x-app-layout>
    <x-slot name="title">
        Client: {{ $client->name }}
    </x-slot>
    <div class="col-lg-12">
        <div>
            <x-alert></x-alert>
        </div>
        <div class="row">
            @empty($client->schedule)
            This Client is not in any Schedule
            @endempty
            @isset($client->schedule)
            <div class="jumbotron">
                <h4 class="display-6">Subscribed to {{$client->schedule->name}} </h4>
                <p class="lead">This application sends automated emails when the system is idle. Midnight or early in
                    the morning</p>
                <hr class="my-4">
                <p class="lead">
                    {{-- <a class="btn btn-primary btn-lg" href="#" role="button">Edit Us</a> --}}
                </p>
            </div>
            @endisset

        </div>

        <div class="row">
           <form method="POST" action=" {{ route('client.sendstatement') }} ">
                @csrf
                <input name="id" type="hidden" value=" {{ $client->id }} ">
                <button class="btn btn-outline-success"><i class="ion ion-md-paper-plane"></i> Send Statement Report <i
                        class="ion ion-md-attach"></i></button>
            </form>


        </div>
        <br>
        <div class="row">
            <div class="list-group col-8">


                @forelse ($client->emailactivities as $activity)
                <a href="#" class="list-group-item list-group-item-action active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"> Email Sent &bull; <span><small> {{$activity->created_at->diffForHumans()}}
                                </small></span>
                        </h5>

                    </div>
                    <p class="mb-1"> {{$activity->desc}} </p>
                    <small> By: {{$activity->user->name?  $activity->user->name:"Scheduled" }} </small>
                </a>
                @empty
                No Email Sent to this client
                @endforelse


            </div>
        </div>
    </div>

</x-app-layout>