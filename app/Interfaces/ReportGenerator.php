<?php

namespace App\Interfaces;
/**
 * Interface ReportGenerator
 * @package App\Interfaces
 * Interface responsável por gerar relatórios
 */
interface ReportGenerator
{
    public function generate(array $data, string $view, string $fileName): PDF;
}
