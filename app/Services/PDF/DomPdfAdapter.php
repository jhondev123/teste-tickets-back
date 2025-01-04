<?php

namespace App\Services\PDF;

use App\Interfaces\PDF;
use Barryvdh\DomPDF\PDF as DomPDF;

/**
 * Class DomPdfAdapter
 * @package App\Services\PDF
 * @param DomPDF $pdf
 * Classe responsável por adaptar o DomPDF para a interface PDF
 *
 */
readonly class DomPdfAdapter implements PDF
{
    public function __construct(private DomPDF $pdf)
    {
    }

    public function stream(): string
    {
        return $this->pdf->stream();
    }

    public function download(): string
    {
        return $this->pdf->download();
    }

    public function save(string $path): void
    {
        $this->pdf->save($path);
    }
}
