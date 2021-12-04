<?php

namespace App\Http\Controllers;

use App\Imports\ClientsSummaryImport;
use App\Models\ClientSummary;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientSummaryController extends Controller
{
   
    public function index()
    {
        $clients=ClientSummary::all();
        return view('summary-excel.index',
        [
            'clients'=>$clients
        ]
    );
    }

 
    public function store()
    {
        Excel::import(new ClientsSummaryImport, request()->file('file'));
        return back();
    }

   
    public function create()
    {
       return view('summary-excel.create');
    }


    public function show(ClientSummary $clientSummary)
    {
        //
    }

    public function edit(ClientSummary $clientSummary)
    {
        //
    }


    public function update(Request $request, ClientSummary $clientSummary)
    {
        //
    }

  
    public function destroy(ClientSummary $clientSummary)
    {
        //
    }
}
