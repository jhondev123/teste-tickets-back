<?php

namespace App\Actions\V1\Report;

use App\Http\Requests\Api\V1\Report\SearchTicketsRequest;
use App\Models\Ticket;
use Carbon\Carbon;

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

        if ($request->has('start_date') && !empty($request->get('start_date'))) {
            $start_date = Carbon::parse($request->get('start_date'))->format('Y-m-d');
            $query->where('tickets.created_at', '>=', $start_date);
        }
        if ($request->has('end_date') && !empty($request->get('end_date'))) {
            $end_date = Carbon::parse($request->get('end_date'))->format('Y-m-d');
            $query->where('tickets.created_at', '<=', $end_date);
        }

        if ($request->has('situation') && !empty($request->get('situation'))) {
            $query->where('tickets.situation', mb_strtoupper($request->get('situation')));
        }

        if ($request->has('slug') && !empty($request->get('slug'))) {
            $slug = $request->get('slug');
            $query->where(function ($subQuery) use ($slug) {
                $subQuery->where('tickets.id', 'like', '%' . $slug . '%')
                    ->orWhere('tickets.employee_id', 'like', '%' . $slug . '%')
                    ->orWhere('employees.name', 'like', '%' . $slug . '%')
                    ->orWhere('tickets.quantity', 'like', '%' . $slug . '%');
            });
        }

        $query->join('employees', 'employees.id', '=', 'tickets.employee_id')
            ->select('tickets.*', 'employees.name as employee_name')
            ->groupBy('tickets.id')
            ->orderBy('tickets.employee_id');

        return $query->get();
    }
}
