<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('schedule.index', [
            'schedules' => Schedule::all(),
        ]);
    }

    public function create()
    {

        $contacts = Contact::query()
            ->select('ContactID', 'FirstName', 'LastName', 'ContactName', 'Email','DeliveryName', 'ContactCode')
            ->get();

        $withoutschedules = $contacts->filter(function ($contact) {

            if (!$contact->contactSchedule()->exists()) {
                return $contact;
            }
        });

        return view('schedule.create', [
            'clients' => $withoutschedules
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'dispatch_date' => 'required|date|after:tomorrow',
            'clients' => 'required'
        ]);

        $schedule = new Schedule;
        $schedule->name = $request->name;
        $schedule->user_id = Auth::id();
        $schedule->dispatch_date = $request->dispatch_date;
        $schedule->frequency = $request->frequency;
        $schedule->desc = $request->desc;
        $schedule->save();
        foreach ($request->clients as $client) {
            if (ContactSchedule::where('ContactID', $client)->count() > 0) {
                ContactSchedule::where('ContactID', $client)
                    ->update([
                        'schedule_id' => $schedule->id
                    ]);
            } else {
                $contactSchedule = new ContactSchedule;
                $contactSchedule->ContactID = $client;
                $contactSchedule->schedule_id = $schedule->id;
                $contactSchedule->save();
            }
        }

        return redirect('/schedule')->with('success', 'Added Successfully!');
    }


    public function show($schedule)
    {


        $schedule = Schedule::with('contactSchedules.contact:ContactID,FirstName,LastName,DeliveryName,Email', 'emails')->findorFail($schedule);

        return view(
            'schedule.show',
            [
                'schedule' => $schedule,

            ]
        );
    }


    public function pending()
    {
        return view('schedule.pending', [
            'pendingSchedules' => Schedule::pending()->get(),
        ]);
    }

    public function approve(Request $request, Schedule $schedule)
    {
        $schedule->update([
            'status' => 'approved',
            'approved_by' => auth()->id()
        ]);

        return back()->with('success', 'Successfully Approved');
    }

    public function reject(Request $request, Schedule $schedule)
    {
        $schedule->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);
        return back()->with('success', 'Schedule Rejected!');
    }


    public function add_contacts(Schedule $schedule)
    {
        return view('schedule.add', [
            'clients' => Contact::has('portfolios', '>=', 1)->select(['FirstName', 'LastName', 'ContactID', 'MiddleName', 'DeliveryName', 'ContactName'])->get(),
            'schedule' => $schedule
        ]);
    }

    public function addcontacts(Request $request, Schedule $schedule)
    {

        $schedule->contactSchedules()->delete();
        foreach ($request->clients as $client) {

            $contactSchedule = new ContactSchedule;
            $contactSchedule->ContactID = $client;
            $contactSchedule->schedule_id = $schedule->id;
            $contactSchedule->save();
        }

        return back()->with('success', 'Successfully Updated');
    }

    // Summary
    public function summary(Schedule $schedule)
    {
        $totals = DB::table('email_activities')
            ->where('schedule_id', $schedule->id)
            ->whereMonth('created_at', now()->format('m'))
            ->selectRaw("count(case when status = 'sent' then 1 end) as totalAll")
            ->selectRaw('count(distinct(ContactID)) as total')
            ->selectRaw("count(distinct(ContactID), case when status = 'sent' then 1 end) as sent")
            ->selectRaw("count(distinct(ContactID), case when status = 'failed' then 1 end) as failed")
            ->first();

        // dd($totals->total);
        $valueThisMonth = $schedule->emails()->whereMonth('created_at', now()->format('m'))->where('status', 'sent')->sum('endPortfolio');
        return view(
            'schedule.summary',
            [
                'totals' => $totals,
                'schedule' => $schedule,
                'valueThisMonth' => $valueThisMonth,
            ]
        );
    }

    public function sentEmails(Schedule $schedule)
    {
        $sent = $schedule->emails()->whereMonth('created_at', now()->format('m'))->where('status', 'sent')->get();
        return view('schedule.filter.sent', [
            'contacts' => $sent,
            'schedule' => $schedule

        ]);
    }

    public function failedEmails(Schedule $schedule)
    {
        $failed = $schedule->emails()->whereMonth('created_at', now()->format('m'))->where('status', 'failed')->get();

        return view('schedule.filter.failed', [
            'contacts' => $failed,
            'schedule' => $schedule

        ]);
    }

    public function noEmails(Schedule $schedule)
    {
        return view('schedule.filter.noemails');
    }

    public function withoutschedules()
    {

        $contacts = Contact::query()
            ->select('ContactID', 'FirstName', 'LastName', 'DeliveryName', 'Email', 'ContactCode', 'ContactGroupTypeName')
            ->with('contactSchedule')
            ->get();

        $withoutschedules = $contacts->filter(function ($contact) {

            if (!$contact->contactSchedule()->exists()) {
                return $contact;
            }
        });


        return view(
            'schedule.without',
            [
                'contacts' => $withoutschedules,
            ]
        );
    }

    public function duplicates(Schedule $schedule)
    {
        $unique = $schedule->contactSchedules->unique('ContactID');
        $duplicates = $schedule->contactSchedules->diff($unique);

        foreach ($duplicates as $duplicate) {
            DB::table('contact_schedules')->where('id', $duplicate->id)->delete();
        }

        return $duplicates;
    }

    public function upcoming()
    {
        return view('schedule.upcoming');
    }

    public function delete(Schedule $schedule)
    {

        $schedule->delete();
        $schedule->contactSchedules()->delete();

        return redirect('/schedule')->with('success', 'Deleted Successfully');
    }
}
