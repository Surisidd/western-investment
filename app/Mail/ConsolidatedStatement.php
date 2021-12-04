<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ConsolidatedStatement extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $startDate;
    public $endDate;

    public function __construct(Contact $contact,$startDate,$endDate)
    {
        $this->contact=$contact;
        $this->startDate=$startDate;
        $this->endDate=$endDate;
    }
  
    public function build()
    {
        return $this->markdown('emails.clients.statement',[
            'first_name'=>$this->contact->full_name,
            'date' =>new \DateTime($this->endDate),
        ])->attachData(consolidatedPDF($this->contact,$this->startDate,$this->endDate)->output(),$this->contact->full_name.'-'.now().'.pdf',[
                    'mime'=>'application/pdf'
                ])->subject('Statement as at '.(new \DateTime($this->endDate))->format('jS F Y').'');
    }
}
