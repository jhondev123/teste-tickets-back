<?php

namespace App\Actions\V1\Report;

use App\Http\Requests\Api\V1\Report\SearchTicketsRequest;
use App\Interfaces\PDF;
use App\Interfaces\ReportGenerator;
use App\Utils\Cpf;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GenerateReportTicketsAction
 * @param ReportGenerator $reportGenerator
 * @param SearchTicketsByEmployeeAndPeriodAction $action
 * Gera o relatório de tickets usando a consulta de tickets por funcionário e período
 * @package App\Actions\V1\Reports
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
        $tickets->load('employee');
        $tickets = $this->formatCpf($tickets);


        return $this->reportGenerator->generate(
            $tickets->toArray(),
            'reports.tickets',
            'tickets.pdf'
        );
    }

    public function formatCpf(Collection $tickets): Collection
    {
        return $tickets->map(function ($ticket) {
            $ticket->employee->cpf = Cpf::format($ticket->employee->cpf);
            return $ticket;
        });

    }

}
