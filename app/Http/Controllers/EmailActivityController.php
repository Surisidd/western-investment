<?php

namespace App\Http\Controllers;

use App\Models\EmailActivity;
use Illuminate\Http\Request;

class EmailActivityController extends Controller
{
   
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        return view('emails.all',[
            'emails' =>EmailActivity::query()
                ->with('contact:FirstName,DeliveryName,LastName,ContactID')
                ->get()
        ]);
    }


    public function failed()
    {
        return view('emails.failed',[
            'emails' =>EmailActivity::query()
                ->with('contact:FirstName,DeliveryName,LastName,ContactID')
                ->where('status','failed')
                ->get()
        ]);
    }

    public function thismonth()
    {
        return view('emails.thismonth',[
            'emails'=>EmailActivity::query()
            ->with('contact:FirstName,DeliveryName,LastName,ContactID')

                ->whereMonth('created_at', now()->format('m'))
                ->where('status','sent')
                ->get()

        ]);
    }
    public function failedthismonth()
    {
        return view('emails.failedthismonth',[
            'emails' =>EmailActivity::query()
                ->with('contact:FirstName,DeliveryName,LastName,ContactID')
                ->whereMonth('created_at', now()->format('m'))

                ->where('status','failed')
                ->get()
        ]);
    }



   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
