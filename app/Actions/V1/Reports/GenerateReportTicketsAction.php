<?php

namespace App\Actions\V1\Reports;

use App\Http\Requests\Api\V1\Reports\SearchTicketsRequest;
use App\Interfaces\ReportGenerator;
use App\Models\Ticket;
use Barryvdh\DomPDF\PDF;

class GenerateReportTicketsAction
{
    public function __construct(
        private Ticket                         $ticket,
        private readonly ReportGenerator       $reportGenerator,
        private SearchTicketsByEmployeeAndPeriodAction $action
    )
    {
    }

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
