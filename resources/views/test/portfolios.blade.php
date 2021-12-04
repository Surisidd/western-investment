<x-app-layout>
    <x-slot name="title">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href=" {{route('contacts.show',$contact->ContactID)}}
        ">{{$contact->full_name}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Summary</li>
        </ol>
        </nav>

    </x-slot>

{{-- Mutual Funds --}}


<table class="table table-striped table-bordered">

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Security</th>
      <th scope="col">Beginning Market Value</th>
      <th scope="col">Additions Purchases</th>
      <th scope="col">Withdrawals Purchases</th>
      <th scope="col">Gain/Loss</th>
      <th scope="col">Ending Market Value</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th></th>
      <th colspan="6">Mutual Funds</th>
    </tr>
@forelse ($mutualFunds as $mutualfund)
<tr>
  <th scope="row"> {{$loop->iteration}} </th>
  <td> {{$mutualfund->FullName}} </td>
  <td> {{ number_format((float)$mutualfund->startUnits* securityPrice($mutualfund->SecurityID1,$startDate),2,'.',',')}} </td>
  <td> {{ number_format((float)$mutualfund->boughtUnits*securityPrice($mutualfund->SecurityID1,$endDate),2,'.',',')}} </td>
  <td> {{ number_format((float)$mutualfund->soldUnits*securityPrice($mutualfund->SecurityID1,$endDate),2,'.',',')}} </td>

  <td> {{  number_format((float)($mutualfund->endUnits)-($mutualfund->startUnits)*securityPrice($mutualfund->SecurityID1,$endDate),2,'.',',')}} </td>
  <td>{{ number_format((float)($mutualfund->endUnits)*securityPrice($mutualfund->SecurityID1,$endDate),2,'.',',')}} </td>
</tr>
@empty
    <tr>
      <td colspan="5">
        No Mutual Funds Holding
      </td>
    </tr>
@endforelse

<tr>
  <th></th>
  <th colspan="6">Equities</th>
</tr>
@forelse ($equities as $equity)
<tr>
  <th scope="row"> {{$loop->iteration}} </th>
  <td> {{$equity->FullName}} </td>
  <td> {{ number_format((float)$equity->startUnits*securityPrice($equity->SecurityID1,$startDate),2,'.',',')}} </td>

  <td> {{ number_format((float)$equity->boughtUnits*securityPrice($equity->SecurityID1,$endDate),2,'.',',')}} </td>
  <td> {{number_format((float)$equity->soldUnits*securityPrice($equity->SecurityID1,$endDate),2,'.',',')}} </td>
  <td> {{ number_format((float)($equity->endUnits*securityPrice($equity->SecurityID1,$endDate))-(($equity->startUnits*securityPrice($equity->SecurityID1,$startDate))+($equity->boughtUnits*securityPrice($equity->SecurityID1,$endDate))+($equity->soldUnits*securityPrice($equity->SecurityID1,$endDate))),2,'.',',') }} </td>
  <td>{{number_format((float)$equity->endUnits*securityPrice($equity->SecurityID1,$endDate),2,'.',',')}} </td>
</tr>
@empty
    <tr>
      <td colspan="5">
        No Equities Holding
      </td>
    </tr>
@endforelse
   
   

  </tbody>
</table>



{{-- Equities --}}
{{-- <p>
  Equities 
</p>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Security</th>
      <th scope="col">Beginning Market Value</th>
      <th scope="col">Gain/Loss</th>
      <th scope="col">Ending Market Value</th>

    </tr>
  </thead>
  <tbody>

    @foreach ($equities as $equity)
    <tr>
      <th scope="row"> {{$loop->iteration}} </th>
      <td> {{$equity->FullName}} </td>
      <td> {{$equity->startUnits}} </td>
      <td> {{($equity->endUnits)-($equity->startUnits)}} </td>
      <td>{{$equity->endUnits}} </td>
    </tr>
    @endforeach
   

  </tbody> --}}
</table>

   
</x-app-layout>