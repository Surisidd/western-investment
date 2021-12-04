<?php

namespace App\Http\Controllers;

use App\Models\ContactSchedule;
use Illuminate\Http\Request;

class ContactScheduleController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
  

    public function create(){
        return view('contactsschedule.create');
    }
    public function destroy(ContactSchedule $contactSchedule)
    {

        $contactSchedule->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
