<?php

namespace App\Mail;

use App\Models\ClientSummary as ModelsClientSummary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public function __construct(ModelsClientSummary $client)
    {
        $this->client=$client;
    }

    
    public function build()
    {
        return $this->markdown('emails.clientsummary',[
            'first_name' => $this->client->client,
            'date' => new \DateTime('2021-08-31'),
            ])->attachData(portfolioSummaryPDF($this->client)->output(),$this->client->client.'-'.now().'.pdf',[
                'mime'=>'application/pdf'
            ])->subject('Statement as at '.(new \DateTime('2021-08-31'))->format('jS F Y').'');
}
}
