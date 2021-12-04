<?php

namespace App\Http\Controllers;

use App\Mail\EmailPassword;
use Illuminate\Http\Request;
use App\Models\ContactPassword;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactPasswordController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        return view('contact-passwords.index', [
            'contacts' => ContactPassword::Query()
                ->with('contact:ContactID,FirstName,LastName,MiddleName,DeliveryName')
                ->get(),
        ]);
    }

    public function missing()
    {
        $contacts = Contact::query()
        ->select('ContactID', 'FirstName', 'LastName', 'ContactName', 'Email', 'ContactCode', 'ContactGroupTypeName')

                            ->with('contactPassword')
                            ->get()
                            ;

        $without = [];

        foreach ($contacts as $contact) {
        }


        $withoutPasswords = $contacts->filter(function ($contact) {

            if (!$contact->contactPassword()->exists()) {
                return $contact;
            }
        });


        return view('contact-passwords.missing', [
            'contacts' => $withoutPasswords

        ]);
    }


    public function sendMissing()
    {
        $contacts = Contact::query()
        ->select('ContactID', 'FirstName', 'LastName', 'ContactName', 'Email', 'ContactCode', 'ContactGroupTypeName')

                            ->with('contactPassword')
                            ->get()
                            ;


     


        $withoutPasswords = $contacts->filter(function ($contact) {

            if (!$contact->contactPassword()->exists()) {
                return $contact;
            }
        });

        // Send Passwords Emails
        foreach($withoutPasswords as $contact){
            foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {
                if(!empty($recipient)){
                    $contact->contactPassword()->updateOrCreate([
                        'ContactID' => $contact->ContactID,
                        'password' => rand(100000, 999999),
                        'user_id' => auth()->id()
                    ]);

                    Mail::to($recipient)->queue(new EmailPassword($contact));
                }
            }
        }
        return view('contact-passwords.missing', [
            'contacts' => $withoutPasswords
        ]);
    }


    public function edit(ContactPassword $contactPassword)
    {

        return view('contact-passwords.edit', [
            'contactPassword' => $contactPassword
        ]);
    }

    public function update(ContactPassword $contactPassword)
    {


        $contactPassword->update([
            'password' => rand(100000, 999999),
        ]);

        foreach ([$contactPassword->contact->Email, $contactPassword->contact->Email2, $contactPassword->contact->Email3] as $recipient) {
            Mail::to($recipient)->queue(new EmailPassword($contactPassword->contact));
        }

        return back()->with('success', 'Password successfully reset and emailed to the client(s)!');
    }

    public function create(Contact $contact)
    {
        return view('contact-passwords.create', [
            'contact' => $contact,
        ]);
    }


    public function store(Contact $contact)
    {

        $contact->contactPassword()->delete();
        $contact->contactPassword()->updateOrCreate([
            'ContactID' => $contact->ContactID,
            'password' => rand(100000, 999999),
            'user_id' => auth()->id()
        ]);

        foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {
            if(!empty($recipient)){
            Mail::to($recipient)->queue(new EmailPassword($contact));
            }
        }

        return redirect(route('contact-password.edit', $contact->contactPassword()->first()->id))->with('success', 'Password successfully created and sent via Email!');
    }

    public function send(Contact $contact)
    {
        foreach ([$contact->Email, $contact->Email2, $contact->Email3] as $recipient) {
            if(!empty($recipient)){
                Mail::to($recipient)->queue(new EmailPassword($contact));
            }
        }

        return back()->with('success', 'Password Sent to specified  Email(s) on APX!');
    }

    public function deletepassword(Contact $contact){
        $contact->contactPassword()->delete();
        return redirect(route('contact-password.create.password', $contact->ContactID))->with('success', 'Password Removed, user can now use their ID/Passport onward');
    }
}
