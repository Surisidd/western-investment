<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Illuminate\Console\Command;

class GeneratePasswords extends Command
{

    protected $signature = 'Passwords:Generate';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

  
    public function handle()
    {
        $contacts = Contact::all();
        foreach($contacts as $contact){
            $contact->contactPassword()->updateOrCreate([
                'ContactID' =>$contact->ContactID,
                'password'=>rand(100000,999999),
                'user_id'=>auth()->id()
            ]);
            


        }
        
    }
}
