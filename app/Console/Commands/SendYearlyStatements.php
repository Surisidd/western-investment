<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendYearlyStatements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send yearly statements to clients via emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        return 0;
    }
}
