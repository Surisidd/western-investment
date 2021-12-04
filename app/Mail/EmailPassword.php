<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct($contact)
    {
        $this->contact=$contact;
    }

 
    public function build()
    {
        return $this->markdown('emails.passwords',[
            'name'=>$this->contact->full_name
        ])->subject('Western Client Statement Password');
    }
}