<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExceptionOccured extends Mailable
{
    use Queueable, SerializesModels;

    public $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;

    }

  
    public function build()
    {
        return $this->view('emails.exception')
        ->with('errors', $this->errors);

    }
}
