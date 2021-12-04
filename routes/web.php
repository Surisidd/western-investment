<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSummaryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactPasswordController;
use App\Http\Controllers\ContactScheduleController;
use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailActivityController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StatementTemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactCurrencyController;
use App\Http\Controllers\PortfolioTestController;
use Illuminate\Support\Facades\Route;
use App\Models\Contact;
use App\Models\SecurityType;
use App\Transactions\MutualFunds;
use App\Transactions\Transactions;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\ContactControllerTest;
use App\Models\ClientSummary;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::post('/test/contacts/{contact}/consolidated/send',[ContactControllerTest::class,'sendConsolidated'])->name('test.summary.send')->middleware('auth');
Route::get('/test/contacts/{contact}/summary',[ContactControllerTest::class,'summary'])->name('test.contacts.summary')->middleware('auth');
Route::get('/test/contacts/{contact}/consolidated',[ContactControllerTest::class,'consolidated'])->name('test.contacts.consolidated')->middleware('auth');
Route::get('/test/contacts/{contact}/consolidated/pdf',[ContactControllerTest::class,'consolidatedPdf'])->name('test.contacts.consolidated.pdf')->middleware('auth');

// Contacts
Route::resource('contacts', ContactController::class);

// Portfolio
Route::get('/contacts/portfolio/{portfolio}', [ContactController::class, 'portfolio'])->name('contacts.portfolio');
Route::get('/contacts/{portfolio}/download', [ContactController::class, 'downloadPDF'])->name('contacts.portfolio.download');
Route::post('/contacts/{portfolio}/send', [ContactController::class, 'sendStatement'])->name('contacts.portfolio.send');

// Consolidated
Route::get('/contacts/consolidated/{contact}', [ContactController::class, 'consolidated'])->name('contacts.consolidated');
Route::get('/contacts/consolidated/{contact}/download', [ContactController::class, 'downloadConsolidatedPDF'])->name('contacts.consolidated.download');
Route::post('/contacts/consolidated/{contact}/send', [ContactController::class, 'sendConsolidated'])->name('contacts.consolidated.send');


// Clients
Route::resource('client', ClientController::class);

// Users
Route::resource('user', UserController::class);


// Schedules
Route::post('/schedule/{schedule}/addcontacts/save', [ScheduleController::class, 'addcontacts'])->name('schedule.addcontacts.save');
Route::get('/schedule/{schedule}/addcontacts', [ScheduleController::class, 'add_contacts'])->name('schedule.addcontacts');
Route::post('/schedule/{schedule}/reject', [ScheduleController::class, 'reject'])->name('schedule.reject');
Route::post('/schedule/{schedule}/approve', [ScheduleController::class, 'approve'])->name('schedule.aprove');
Route::get('/schedule/{schedule}/duplicate', [ScheduleController::class, 'duplicates'])->name('schedule.duplicates');
Route::get('/schedule/pending', [ScheduleController::class, 'pending'])->name('schedule.pending');
Route::get('/schedule/{schedule}/approve', [ScheduleController::class, 'approve'])->name('schedule.approve');
Route::get('schedule/upcoming', [ScheduleController::class, 'upcoming'])->name('schedule.upcoming');
Route::get('/schedule/{schedule}/summary', [ScheduleController::class, 'summary'])->name('schedule.summary');
Route::get('/schedule/contact/missing', [ScheduleController::class, 'withoutschedules'])->name('schedule.missing.contacts');
Route::post('/schedule/{schedule}/delete', [ScheduleController::class, 'delete'])->name('schedule.delete');
Route::get('/schedule/{schedule}/sent', [ScheduleController::class, 'sentEmails'])->name('schedule.sent');
Route::get('/schedule/{schedule}/failed', [ScheduleController::class, 'failedEmails'])->name('schedule.failed');

Route::resource('schedule', ScheduleController::class);

// ContactSchedules
Route::delete('contactschedules/{contactSchedule}', [ContactScheduleController::class, 'destroy'])->name('contactschedules.destroy');
Route::get('/statement/pdf-view', [StatementTemplateController::class, 'statement']);
Route::get('statements/pdf', [StatementTemplateController::class, 'pdf'])->name('statement-pdf');
Route::resource('statements', StatementTemplateController::class);

// Emails
Route::get('/emails', [EmailActivityController::class, 'index'])->name('emails.all');
Route::get('/emails/thismonth', [EmailActivityController::class, 'thismonth'])->name('emails.thismonth');
Route::get('/emails/failed', [EmailActivityController::class, 'failed'])->name('emails.failed');
Route::get('/emails/failed/thismonth', [EmailActivityController::class, 'failedthismonth'])->name('emails.failed.thismonth');

// Dashboard
Route::get('/dashboard', DashboardController::class)->name('dashboard');


// Contacts passwords
Route::get('contact-password/{contact}/password', [ContactPasswordController::class, 'create'])->name('contact-password.create.password');
Route::post('contact-password/{contact}/password', [ContactPasswordController::class, 'store'])->name('contact-password.create.password.save');
Route::post('/contact/{contact}/password/send', [ContactPasswordController::class, 'send'])->name('contact.password.send');
Route::get('contacts/missing/passwords', [ContactPasswordController::class, 'missing'])->name('contacts.missing.password');
Route::get('contacts/missing/passwords/send', [ContactPasswordController::class, 'sendMissing'])->name('contacts.missing.password.send');
Route::post('contacts/{contact}/passwords/delete', [ContactPasswordController::class, 'deletepassword'])->name('contacts.password.delete');


Route::resource('contact-password', ContactPasswordController::class);

// Currency Rates
Route::get('/currencyrates', [CurrencyRateController::class, 'index'])->name('currencyrates');

// Contact Currency
Route::resource('contactcurrency', ContactCurrencyController::class);

// Archives
Route::get('/archives/download', [ArchiveController::class, 'downloadAll'])->name('archives.download');
Route::get('/archives/download/{name}', [ArchiveController::class, 'downloadFile'])->name('archives.download.file');
Route::get('/archives/generate', [ArchiveController::class, 'generate'])->name('archives.generate');
Route::resource('archives', ArchiveController::class);


// Excel Summary
Route::get('/client-summary-excel',[ClientSummaryController::class,'index'])->name('allimported')->middleware('auth');
Route::get('/client-summary-excel/create',[ClientSummaryController::class,'create'])->name('create.import')->middleware('auth');
Route::post('/client-summary-excel',[ClientSummaryController::class,'store'])->name('import')->middleware('auth');