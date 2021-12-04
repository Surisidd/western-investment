<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactCurrency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;

class ContactCurrencyController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        return view('contactcurrency.index',[
            'contacts' => ContactCurrency::Query()
            ->with('contact:ContactID,FirstName,LastName,MiddleName,DeliveryName')
            ->get(),
        ]);
    }

    public function create()
    {
        return view('contactcurrency.create',[
            'currencies'=>CurrencyRate::all(),
            'contacts' => Contact::query()
            ->select('ContactID', 'FirstName', 'LastName', 'MiddleName', 'DeliveryName')
            ->with('portfolios:PortfolioCode,OwnerContactID')
            ->get()

        ]);
    }

    public function store(Request $request){

        if(Contact::find($request->contact)->currency){
            return back()->with('error','User Already set currency');
        } else{
            $contact= new ContactCurrency;
        $contact->ContactID=$request->contact;
        $contact->currency=$request->currency;
        
        $contact->save();
        return back()->with('success','Saved Successfully');
        }

        
    }

    public function edit(Contact $contactcurrency){

        // dd($contactcurrency);

        return view('contactcurrency.edit',[
            
            'contact'=>$contactcurrency
        ]);

    }


    public function update(Contact $contactcurrency,Request $request){
        $contactcurrency->currency->update([
            'currency'=>$request->currency
        ]);

        return back()->with('success','Updated!');
    }

    public function destroy(Contact $contactcurrency){
        // dd($contactcurrency);
        $contactcurrency->currency()->delete();
        return back()->with('success','Deleted Successfully!');
    }
}
