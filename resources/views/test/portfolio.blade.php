<x-app-layout>
    <x-slot name="title">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href=" {{route('contacts.show',$contact->ContactID)}} ">{{$contact->full_name}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$portfolioCode}}</li>
            </ol>
        </nav>

    </x-slot>

    
   
</x-app-layout>