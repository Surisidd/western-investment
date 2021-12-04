<?php

namespace App\Console\Commands;

use App\Mail\PasswordReminder;
use Illuminate\Console\Command;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class SendPasswordReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Passwords:SendReminder';

    
    protected $description = 'Send Passwords Reminder to clients';

  
    public function __construct()
    {
        parent::__construct();
    }

  
    public function handle()
    {
        $contacts=Contact::all();
        foreach($contacts as $contact){

            if($contact->contactPassword()->exists()){
                foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {

                    if(!empty($recipient)){
                        Mail::to($recipient)
                        ->bcc(['test@western.com', 'operations@Westerncapital.com'])
                        ->queue(new PasswordReminder($contact));
                    }
                }
                $this->info('Password Reminder Sent!....');
            } else{
                $this->warn('Skipped!...');
            }
            

        }
    }
}
