<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientStatement;
use Illuminate\Http\Request;
use App\Models\EmailActivity;
use App\Mail\ConsolidatedStatement;


class ContactController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('contacts.index', [
            'clients' => Contact::query()
                ->select('ContactID', 'FirstName', 'LastName','DeliveryName', 'ContactName', 'Email', 'ContactCode')
                ->get()
        ]);
    }

    // Show Contact
    public function show($contact)
    {

       $contact = Contact::query()
                                ->select('ContactID', 'FirstName', 'LastName','DeliveryName', 'ContactName', 'Email', 'ContactCode', 'ContactGroupTypeName','NationalID','BankDetails','BusinessPhone')
                                ->with(['portfolios:OwnerContactID,PortfolioStatus,ReportHeading1,PortfolioID,PortfolioCode','emailactivities'])->find($contact);
        return view(
            'contacts.show',
            [
                'contact' => $contact,
                'emails' => $contact->emailactivities->sortByDesc('created_at')->take(5)
            ]
        );
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
        $data = portfolio($portfolio, $startDate, $endDate);

        return view('contacts.statements.portfolio', [
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
        return portfolioPDF($portfolio, $startDate, $endDate)->download($portfolio->ReportHeading1 . "-" . now()->format('M-Y') . '.pdf');
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


        foreach ($contact->portfolios as $portfolio){
            $data[]=portfolio($portfolio,$startDate,$endDate);
        }


      
        if ($contact->currency()->count() > 0) {
            $currency = $contact->currency->currency;
        } else {
            $currency = "";
        }
        
        if($currency=="kes"){

            $totalStartValueKES=collect($data)->sum("startValue");
            $totalEndvalueKES=collect($data)->sum("endValue");
            $totalInterestKES=collect($data)->sum("interest");
            $totalContributionsKES=collect($data)->sum("contributions");
            $totalWithdrawalsKES=collect($data)->sum("withdrawals");

            $summaryKES=[
                "startValue" => $totalStartValueKES,
                "endValue"=>$totalEndvalueKES,
                "interest"=>$totalInterestKES,
                "contributions"=>$totalContributionsKES,
                "withdrawals"=>$totalWithdrawalsKES,
            ];

            $summaryUSD=[
                "startValue" => 0,
                "endValue"=>0,
                "interest"=>0,
                "contributions"=>0,
                "withdrawals"=>0,
            ];

        } else{

            $totalStartValueKES=collect($data)->where("currency","ke")->sum("startValue");
            $totalEndvalueKES=collect($data)->where("currency","ke")->sum("endValue");
            $totalInterestKES=collect($data)->where("currency","ke")->sum("interest");
            $totalContributionsKES=collect($data)->where("currency","ke")->sum("contributions");
            $totalWithdrawalsKES=collect($data)->where("currency","ke")->sum("withdrawals");

            $totalStartValueUSD=collect($data)->where("currency","us")->sum("startValue");
            $totalEndvalueUSD=collect($data)->where("currency","us")->sum("endValue");
            $totalInterestUSD=collect($data)->where("currency","us")->sum("interest");
            $totalContributionsUSD=collect($data)->where("currency","us")->sum("contributions");
            $totalWithdrawalsUSD=collect($data)->where("currency","us")->sum("withdrawals");

            $summaryKES=[
                "startValue" => $totalStartValueKES,
                "endValue"=>$totalEndvalueKES,
                "interest"=>$totalInterestKES,
                "contributions"=>$totalContributionsKES,
                "withdrawals"=>$totalWithdrawalsKES,
            ];

            $summaryUSD=[
                "startValue" => $totalStartValueUSD,
                "endValue"=>$totalEndvalueUSD,
                "interest"=>$totalInterestUSD,
                "contributions"=>$totalContributionsUSD,
                "withdrawals"=>$totalWithdrawalsUSD,
            ];
    
        }


       
        return view('contacts.statements.portfolios', [
            'startDate' => $startDate,
            "endDate" => $endDate,
            "contact" => $contact,
            "summaryKES"=>$summaryKES,
            "summaryUSD"=>$summaryUSD
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

    
        return consolidatedPDF($contact, $startDate, $endDate)->download($contact->full_name . "-" . now()->format('M-Y') . '.pdf');
    }

    // Send Consolidated Summary PDF
    public function sendConsolidated(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-3 months'));
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
