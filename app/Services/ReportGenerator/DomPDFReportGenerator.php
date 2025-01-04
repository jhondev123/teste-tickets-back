<?php

namespace App\Services\ReportGenerator;
use App\Interfaces\PDF;
use App\Interfaces\ReportGenerator;
use App\Services\PDF\DomPdfAdapter;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

/**
 * Class DomPDFReportGenerator
 * @package App\Services\ReportGenerator
 * Classe responsável por gerar relatórios em PDF
 */
class DomPDFReportGenerator implements ReportGenerator
{
    /**
     * @param array $data
     * @param string $view
     * @param string $fileName
     * @return PDF
     * Método responsável por gerar o relatório em PDF
     */
    public function generate(array $data, string $view, string $fileName): PDF {
        $domPdf = FacadePdf::loadView($view, compact('data'));
        return new DomPdfAdapter($domPdf);
    }

}
