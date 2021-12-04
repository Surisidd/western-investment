<?php

namespace App\Console\Commands;

use App\Mail\EmailPassword;
use Illuminate\Console\Command;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class EmailPasswords extends Command
{
   
    protected $signature = 'Email:Passwords';

 
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $contacts=Contact::all();
        foreach($contacts as $contact){
            
            foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {

                if(!empty($recipient)){
                    Mail::to($recipient)
                    ->bcc(['operations@Westerncapital.com'])
                    ->queue(new EmailPassword($contact));
                }
            }

        }
    }
}
