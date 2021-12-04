<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Schedule;
use Illuminate\Http\File;



class GenerateStatementsPDF extends Command
{

    protected $signature = 'Generate:PDFs';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Storage::makeDirectory(date('F-Y', strtotime('-1 months')));
        $this->info('Folder Created!');
    
        $schedules = Schedule::where('frequency', 'hourly')->where('status', 'approved')->get();
        foreach ($schedules as $schedule) {
            foreach ($schedule->contactSchedules as $contactSchedule) {
                    // Fund more than 500
                    if ($contactSchedule->contact->endPortfolio() >= 500) {
                        //    Generate PDFs
                        Storage::put('archives/'.date('F-Y', strtotime('-1 months')).'/'.$contactSchedule->contact->full_name.'-'.date('F-Y', strtotime('-1 months')).'.pdf', $contactSchedule->contact->consolidatedPDF()->output());
                    }

                    $this->info('Statement Created!');
                
            }
        }
    }
}
