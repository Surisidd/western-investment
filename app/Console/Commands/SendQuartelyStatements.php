<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Models\Schedule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientStatement;
use App\Mail\ConsolidatedStatement;
use App\Models\EmailActivity;
use App\Models\Portfolio;

class SendQuartelyStatements extends Command
{
   
    protected $signature = 'statement:Quaterly';

   
    protected $description = 'Send quaterly emails to clients';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        $schedules = Schedule::where('frequency', 'hourly')->where('status', 'approved')->get();

        // Dates
        $startDate = date('Y-m-t', strtotime('-2 months'));
        $endDate = date('Y-m-t', strtotime('-1 months'));

        foreach ($schedules as $schedule) {
            foreach ($schedule->contactSchedules as $contactSchedule) {

                // check if the user already received the month email
                if ($contactSchedule->contact->emailactivities()->whereMonth('created_at', now()->format('m'))->count() < 1) {


                        if($contactSchedule->contact->endPortfolio()>=500){
                            try{
                                foreach ([$contactSchedule->contact->Email,$contactSchedule->contact->Email2,$contactSchedule->contact->Email3] as $recipient) {
                                    if (!empty($recipient)) {
                                        Mail::to($recipient)
                                        ->bcc(['test@western.com','operations@Westerncapital.com'])
                                            ->queue(new ConsolidatedStatement($contactSchedule->contact,$startDate,$endDate));
                                            $this->info('Statement sent!');
                                            EmailActivity::create([
                                                'user_id' => auth()->id(),
                                                'schedule_id' => $schedule->id,
                                                'ContactID' => $contactSchedule->contact->ContactID,
                                                'email' => $recipient,
                                                'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                                                'status' => "sent",
                                                'desc'=>$contactSchedule->contact->ReportHeading2
                                            ]);
    
                                    }
                                }
                            } catch(\Exception $e){
                                EmailActivity::create([
                                    'schedule_id' => $schedule->id,
                                    'user_id' => auth()->id(),
                                    'ContactID' => $contactSchedule->contact->ContactID,
                                    'email' => $contactSchedule->contact->Email,
                                    'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                                    'status' => "failed",
                                    'desc' => $e->getMessage()
                                ]); 
                            }
                       
                        } else {
                             // Fund less than 500
                        EmailActivity::create([
                            'user_id' => auth()->id(),
                            'schedule_id' => $schedule->id,
                            'ContactID' => $contactSchedule->contact->ContactID,
                            'email' => $contactSchedule->contact->Email,
                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                            'status' => "failed",
                            'desc' => "funds less than KES 500 - ".$contactSchedule->contact->ReportHeading2.""
                        ]);
                        }

                    
                }
            }
        }
    }
}
