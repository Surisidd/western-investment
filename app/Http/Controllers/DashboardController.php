<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\Contact;
use App\Models\EmailActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {

        $totals = DB::table('email_activities')
        ->whereMonth('created_at',Carbon::now()->month)
                 ->selectRaw('count(*) as total')
                 ->selectRaw("count(case when status = 'sent' then 1 end) as sent")
                 ->selectRaw("count(case when status = 'failed' then 1 end) as failed")
                  ->first();
                //   dd($totals->failed);
        $totalUsers=Contact::all()->count();
               
        $users=DB::table('contacts')
        ->select("ContactID","FirstName","LastName")
        ->orderBy('ContactID','desc')
        ->limit(10)
        ->get();
        $emails=EmailActivity::Query()
                                ->with('contact:ContactID,DeliveryName')
                                ->latest()->limit(10)->get();

        return view('dashboard',[
            'totalusers'=>$totalUsers,
            'users'=>$users,
            'totals'=>$totals,
            'emails'=>$emails,
        ]);
    }
}
