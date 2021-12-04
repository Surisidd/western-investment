<?php

namespace App\Mail;

use App\Models\Portfolio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientStatement extends Mailable
{

    use Queueable, SerializesModels;

    public $portfolio;
    public $startDate;
    public $endDate;

    public function __construct(Portfolio $portfolio, $startDate, $endDate)
    {
        $this->portfolio = $portfolio;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->markdown('emails.clients.statement', [
            'first_name' => $this->portfolio->ReportHeading1,
            'date' => new \DateTime($this->endDate)
        ])
            ->attachData(portfolioPDF($this->portfolio, $this->startDate, $this->endDate)->output(), $this->portfolio->ReportHeading1 . '-' . now() . '.pdf', [
                'mime' => 'application/pdf'
            ])->subject('Statement as at ' . (new \DateTime($this->endDate))->format('jS F Y') . '');
    }
}
