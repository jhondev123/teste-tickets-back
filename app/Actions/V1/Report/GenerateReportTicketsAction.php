<?php

namespace App\Actions\V1\Report;

use App\Http\Requests\Api\V1\Report\SearchTicketsRequest;
use App\Interfaces\ReportGenerator;
use App\Interfaces\PDF;
/**
 * Class GenerateReportTicketsAction
 * @package App\Actions\V1\Reports
 * @param ReportGenerator $reportGenerator
 * @param SearchTicketsByEmployeeAndPeriodAction $action
 * Gera o relatório de tickets usando a consulta de tickets por funcionário e período
 */
readonly class GenerateReportTicketsAction
{
    public function __construct(
        private ReportGenerator                        $reportGenerator,
        private SearchTicketsByEmployeeAndPeriodAction $action
    )
    {
    }

    /**
     * @param SearchTicketsRequest $request
     * @return PDF
     * Método responsável por executar a consulta dos tickets de gerar o relatório
     */
    public function execute(SearchTicketsRequest $request): PDF
    {
        $tickets = $this->action->execute($request);
        return $this->reportGenerator->generate(
            $tickets->load('employee')->toArray(),
            'reports.tickets',
            'tickets.pdf'
        );
    }

}
