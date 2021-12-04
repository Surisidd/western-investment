<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class EmailCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

   
    public function build()
    {
        return $this->markdown('emails.user.credentials');
    }
}
