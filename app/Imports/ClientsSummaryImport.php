<?php

namespace App\Imports;

use App\Models\ClientSummary;
use Maatwebsite\Excel\Concerns\ToModel;


class ClientsSummaryImport implements ToModel
{
    
    public function model(array $row)
    {

        return new ClientSummary([
            'client'=>$row[0],
            'fund'=>$row[1],
            'startValue'=>$row[2],
            'contributions'=>$row[3],
            'redemption'=>$row[4],
            'return'=>$row[5],
            'endValue'=>$row[6],
            'email1'=>$row[7],
        ]);
    }
}
