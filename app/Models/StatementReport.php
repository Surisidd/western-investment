<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDF;

class StatementReport extends Model
{
    use HasFactory;

public function pdf()
{
    $data = [
        'foo' => 'bar'
    ];
    $config = ['instanceConfigurator' => function($mpdf) {
        $mpdf->SetImportUse();
        $mpdf->SetDocTemplate('/template.pdf', true);
    }];
    $pdf = PDF::loadView('statements.statement_pdf', $data,$config);
    $pdf->SetProtection(array(), 'UserPassword', '');
    return $pdf;

}
}
