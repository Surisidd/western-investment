<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Http;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientStatement;
use App\Mail\ConsolidatedStatement;
use App\Models\EmailActivity;

class SendHourlyStatements extends Command
{

    protected $signature = 'Email:SendHourlyStatements';

    protected $description = 'Send Emails Contact Statements PDF Hourly';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $schedules = Schedule::where('frequency', 'hourly')->where('status', 'approved')->get();
        foreach ($schedules as $schedule) {
            foreach ($schedule->contactSchedules as $contactSchedule) {

                // check if the user already received the month email
                if ($contactSchedule->contact->emailactivities()->whereMonth('created_at', now()->format('m'))->count() < 1) {

                    if ($contactSchedule->contact->endPortfolio() >= 500) {
                        // Fund more than 500
                        try {
                            foreach ([$contactSchedule->contact->Email, $contactSchedule->contact->Email2, $contactSchedule->contact->Email3] as $recipient) {
                                // If it is not empty
                                if (!empty($recipient)) {

                                    $validator = new EmailValidator();
                                    $validator->isValid("example@example.com", new RFCValidation()); //true
                                    // validate the email
                                    if ($validator->isValid($recipient, new RFCValidation())) {
                                        Mail::to($recipient)
                                            ->bcc(['test@western.com', 'operations@Westerncapital.com'])
                                            ->queue(new ConsolidatedStatement($contactSchedule->contact));
                                        EmailActivity::create([
                                            'user_id' => auth()->id(),
                                            'schedule_id' => $schedule->id,
                                            'ContactID' => $contactSchedule->contact->ContactID,
                                            'email' => $recipient,
                                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                                            'status' => "sent"
                                        ]);
                                    } else {

                                        EmailActivity::create([
                                            'user_id' => auth()->id(),
                                            'schedule_id' => $schedule->id,
                                            'ContactID' => $contactSchedule->contact->ContactID,
                                            'email' => $recipient,
                                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                                            'status' => "failed",
                                            'desc' => "Invalid Email"
                                        ]);
                                    }
                                }
                            }
                        } catch (\Exception $e) {
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
                        // Fund less than less 10000
                        EmailActivity::create([
                            'user_id' => auth()->id(),
                            'schedule_id' => $schedule->id,
                            'ContactID' => $contactSchedule->contact->ContactID,
                            'email' => $contactSchedule->contact->Email,
                            'endPortfolio' => $contactSchedule->contact->endPortfolio(),
                            'status' => "failed",
                            'desc' => "funds less than KES 500"
                        ]);
                    }
                }
            }
        }
    }
}
