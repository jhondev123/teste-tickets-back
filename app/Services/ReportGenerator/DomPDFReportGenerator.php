<?php

namespace App\Services\ReportGenerator;
use App\Interfaces\ReportGenerator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class DomPDFReportGenerator implements ReportGenerator
{
    public function generate(array $data,string $view, string $fileName): \Barryvdh\DomPDF\PDF
    {
        return FacadePdf::loadView($view, compact('data'));
    }
}
