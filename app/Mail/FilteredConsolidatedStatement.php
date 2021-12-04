<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FilteredConsolidatedStatement extends Mailable
{
    use Queueable, SerializesModels;
    public $contact,$startDate,$endDate;
   
    public function __construct($contact,$startDate,$endDate)
    {
        $this->contact=$contact;
        $this->startDate=$startDate;
        $this->endDate=$endDate;

    }

    public function build()
    {
        return $this->markdown('emails.contacts.filtered',[
            'first_name'=>$this->contact->full_name,
            'date' =>new \DateTime(date('Y-m-d', strtotime($this->endDate))),
        ])->attachData($this->contact->filteredPDF($this->startDate,$this->endDate)->output(),$this->contact->Salutation.'-'.now().'.pdf',[
                    'mime'=>'application/pdf'
                ])->subject('Statement as at '.(new \DateTime(date('Y-m-d', strtotime($this->endDate))))->format('jS F Y').'');
    }
}
