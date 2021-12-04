<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ConsolidatedStatement;
use Illuminate\Http\Request;
use App\Models\EmailActivity;
use Illuminate\Support\Facades\Mail;
use App\Transactions\Transactions;


class ContactControllerTest extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('contacts.test.index', [
            'clients' => Contact::query()
                ->select('ContactID', 'FirstName', 'LastName', 'ContactName', 'Email', 'ContactCode', 'ContactGroupTypeName')
                ->get()
        ]);
    }

    // Show Contact
    public function show($contact)
    {

       $contact = Contact::query()
                                ->select('ContactID', 'FirstName', 'LastName', 'ContactName', 'Email', 'ContactCode', 'ContactGroupTypeName','NationalID')
                                ->with(['portfolios:OwnerContactID,PortfolioStatus,ReportHeading1,PortfolioID,PortfolioCode','emailactivities'])->find($contact);
        return view(
            'contacts.test.show',
            [
                'contact' => $contact,
                'emails' => $contact->emailactivities->sortByDesc('created_at')->take(5)
            ]
        );
    }

    // Consolidated  
    public function summary(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }

      $transactions=new Transactions($contact,$startDate,$endDate);
      $mutualFunds=$transactions->mutualfunds();
      $equities=$transactions->equities();
      $fixedDeposits=$transactions->fixedDeposits();
      $fixedIncome=$transactions->fixedIncome();
      $latestTransactions=$transactions->latestTransactions();
      $summary=$transactions->summary();  

        return view('contacts.test.portfolio', [
            "summary"=>$summary,
            "contact"=>$contact,
            "mutualfunds"=>$mutualFunds,
            "equities"=>$equities,
            "fixedDeposits"=>$fixedDeposits,
            "startDate"=>$startDate,
            "endDate"=>$endDate,
            "fixedincome"=>$fixedIncome,
            "latestTransactions"=>$latestTransactions
        ]);
    }

    // Consolidated PDF
    public function consolidatedPDF(Contact $contact, Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (empty($startDate) && empty($endDate)) {
            $startDate = date('Y-m-t', strtotime('-2 months'));
            $endDate = date('Y-m-t', strtotime('-1 months'));
        }
        return consolidatedPDF($contact,$startDate,$endDate)->stream($contact->full_name.'-'.now().'.pdf');
    }

      // Send Consolidated PDF
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
