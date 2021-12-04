<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientStatement;
use App\Models\EmailActivity;
use App\Mail\ConsolidatedStatement;

class PortfolioTestController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }




    // Portfolio Summary
    public function portfolio(Portfolio $portfolio, Request $request)
    {
        $validated = $request->validate([
            'startDate' => 'date',
            'endDate' => 'date|before:' . date('Y-m-d') . ''
        ]);

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }
        $data = testportfolio($portfolio, $startDate, $endDate);

        return view('test.portfolio', [
            "data" => $data,
            "contact"=>$portfolio->contact,
            "portfolioCode"=>$portfolio->PortfolioCode
        ]);
    }
    // Download Portfolio Summary PDF
    public function downloadPDF(Portfolio $portfolio, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }
        return testportfolioPDF($portfolio, $startDate, $endDate)->download($portfolio->ReportHeading1 . "-" . now()->format('M-Y') . '.pdf');
    }

    // Send/Email Portfolio Summary
    public function sendStatement(Portfolio $portfolio, Request $request)
    {
        $validated = $request->validate([
            'startDate' => 'date',
            'endDate' => 'date|before:' . date('Y-m-d') . ''
        ]);

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }

        try {
            foreach ([$portfolio->contact->Email, $portfolio->contact->Email2, $portfolio->contact->Email3] as $recipient) {
                if (!empty($recipient)) {
                    Mail::to($recipient)
                        ->bcc(['test@western.com', 'v.mosoti@Westerncapital.com', 'g.mungai@Westerncapital.com'])
                        ->queue(new ClientStatement($portfolio, $startDate, $endDate));
                    EmailActivity::create([
                        'user_id' => auth()->id(),
                        'ContactID' => $portfolio->contact->ContactID,
                        'email' => $recipient,
                        'status' => "sent"
                    ]);
                }
            }
        } catch (\Exception $e) {
            EmailActivity::create([
                'user_id' => auth()->id(),
                'ContactID' => $portfolio->contact->ContactID,
                'email' => $portfolio->contact->Email,
                'endPortfolio' => $portfolio->contact->endPortfolio(),
                'status' => "failed",
                'desc' => $e->getMessage()
            ]);
            return back()->with('error', 'Email sending failed!');
        }
        return back()->with('success', 'Email Sent Successfully!');
    }


    // Consolidated Porfolios
    public function consolidated(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }

        $data=testConsolidated($contact,$startDate,$endDate);
        dd($data);
        return view('test.portfolios', [
            "data"=>$data,
            "contact"=>$contact
        ]);
    }

    // Consolidated Portfolio Summary PDF
    public function downloadConsolidatedPDF(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }
        return testconsolidatedPDF($contact, $startDate, $endDate)->download($contact->full_name . "-" . now()->format('M-Y') . '.pdf');
    }

    // Send Consolidated Summary PDF
    public function sendConsolidated(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }
        try {
            foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {
                if (!empty($recipient)) {
                    Mail::to($recipient)
                        ->bcc(['test@western.com', 'operations@Westerncapital.com'])
                        ->queue(new ConsolidatedStatement($contact,$startDate,$endDate));
                    EmailActivity::create([
                        'user_id' => auth()->id(),
                        'ContactID' => $contact->ContactID,
                        'email' => $recipient,
                        'endPortfolio' => $contact->endPortfolio(),
                        'status' => "sent"
                    ]);
                } else {
                }
            }
            return back()->with('success', 'Email on the queue to be sent in few seconds!');
        } catch (\Exception $e) {
            EmailActivity::create([
                'user_id' => auth()->id(),
                'ContactID' => $contact->ContactID,
                'email' => $contact->Email,
                'endPortfolio' => $contact->endPortfolio(),
                'status' => "failed",
                'desc' => $e->getMessage()
            ]);
            return back()->with('error', 'Email sending failed!');
        }
    }
}
