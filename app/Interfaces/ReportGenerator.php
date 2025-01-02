<?php

namespace App\Interfaces;
use Barryvdh\DomPDF\PDF;

interface ReportGenerator
{
    public function generate(array $data, string $view, string $fileName): PDF;
}
