<?php

namespace App\Actions\V1\Report;

use App\Http\Requests\Api\V1\Report\SearchTicketsRequest;
use App\Models\Ticket;

/**
 * Class SearchTicketsByEmployeeAndPeriodAction
 * @package App\Actions\V1\Reports
 * Busca tickets por funcionário e período
 *
 */
readonly class SearchTicketsByEmployeeAndPeriodAction
{
    public function __construct(private Ticket $ticket)
    {

    }
    public function execute(SearchTicketsRequest $request): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->ticket->newQuery();

        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->get('start_date'));
        }
        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->get('end_date'));
        }


        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->get('employee_id'));
        }
        $query->orderBy('employee_id');
        return $query->get();
    }
}
