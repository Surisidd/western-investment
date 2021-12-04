<?php

namespace App\Console\Commands;

use App\Mail\ClientSummary as MailClientSummary;
use App\Models\ClientSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendClientSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send consolidated summary statements from excel';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clients = ClientSummary::all();

        foreach ($clients as $client) {

            // if Not Sent

            if($client->status===NULL || $client->status==="failed"){
                if (!empty($client->email1)) {
                    try {
                        Mail::to(strtolower($client->email1))
                        ->bcc(['test@western.com','operations@Westerncapital.com'])
                            ->send(new MailClientSummary($client));
                        $this->info('Statement sent!');
                        $client->update([
                            'status' => 'sent'
                        ]);
                    } catch (\Exception $e) {
                        // Get error here
                        $client->update([
                            'status' => 'failed',
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

        }
    }
}
