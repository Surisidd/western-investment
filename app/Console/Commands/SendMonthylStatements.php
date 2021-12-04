<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ConsolidatedStatement;
use App\Models\EmailActivity;
use  App\Models\Schedule;
use Illuminate\Support\Facades\Mail;

class SendMonthylStatements extends Command
{
  
    protected $signature = 'statement:monthly';

    protected $description = 'Send monthly contacts statements PDF';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $schedules = Schedule::where('frequency', 'monthly')->where('status', 'approved')->get();
        foreach ($schedules as $schedule) {
            foreach ($schedule->contactSchedules as $contactSchedule) {

                if ($contactSchedule->contact->endPortfolio() >= 1000) {

                    try {
                        Mail::to($contactSchedule->contact->Email)
                            ->bcc(['test@western.com', 'v.mosoti@Westerncapital.com', 'g.mungai@Westerncapital.com'])
                            ->send(new ConsolidatedStatement($contactSchedule->contact));
                        EmailActivity::create([
                            'user_id' => auth()->id(),
                            'schedule_id'=>$schedule->id,
                            'ContactID' => $contactSchedule->contact->ContactID,
                            'email' => $contactSchedule->contact->Email,
                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                            'status' => "sent"
                        ]);
                    } catch (\Exception $e) {
                        EmailActivity::create([
                            'schedule_id'=>$schedule->id,
                            'user_id' => auth()->id(),
                            'ContactID' => $contactSchedule->contact->ContactID,
                            'email' => $contactSchedule->contact->Email,
                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                            'status' => "failed",
                            'desc' => $e->getMessage()
                        ]);
                    }
                } else {
                    EmailActivity::create([
                        'user_id' => auth()->id(),
                        'schedule_id'=>$schedule->id,
                        'ContactID' => $contactSchedule->contact->ContactID,
                        'email' => $contactSchedule->contact->Email,
                        'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                        'status' => "failed",
                        'desc' => "funds less than 1000"
                    ]);
                }
            }
        }
    }
}
