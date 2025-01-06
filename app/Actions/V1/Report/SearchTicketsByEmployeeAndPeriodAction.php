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

        $this->applyDateFilters($query, $request);
        $this->applySituationFilter($query, $request);
        $this->applySlugFilter($query, $request);

        $this->joinEmployeeTable($query);

        $query->groupBy('tickets.id', 'employees.name')
            ->orderBy('tickets.employee_id');

        return $query->get();
    }

    /**
     * Aplica filtros de data
     *
     * @param $query
     * @param SearchTicketsRequest $request
     */
    private function applyDateFilters($query, SearchTicketsRequest $request): void
    {
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->get('start_date'))->format('Y-m-d');
            $query->where('tickets.created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->get('end_date'))->format('Y-m-d');
            $query->where('tickets.created_at', '<=', $endDate);
        }
    }

    /**
     * @param $query
     * @param SearchTicketsRequest $request
     * @return void
     * Aplica filtro de situação
     */
    private function applySituationFilter($query, SearchTicketsRequest $request): void
    {
        if ($request->filled('situation')) {
            $situation = mb_strtoupper($request->get('situation'));
            $query->where('tickets.situation', $situation);
        }
    }

    /**
     * @param $query
     * @param SearchTicketsRequest $request
     * @return void
     * Aplica filtro de slug
     */
    private function applySlugFilter($query, SearchTicketsRequest $request): void
    {
        if ($request->filled('slug')) {
            $slug = $request->get('slug');
            $query->where(function ($subQuery) use ($slug) {
                $subQuery->where('tickets.id', 'like', '%' . $slug . '%')
                    ->orWhere('tickets.employee_id', 'like', '%' . $slug . '%')
                    ->orWhere('employees.name', 'like', '%' . $slug . '%')
                    ->orWhere('tickets.quantity', 'like', '%' . $slug . '%');
            });
        }
    }

    /**
     * @param $query
     * @return void
     * Junta a tabela de funcionários
     */
    private function joinEmployeeTable($query): void
    {
        $query->join('employees', 'employees.id', '=', 'tickets.employee_id')
            ->selectRaw(
                'tickets.*,
            employees.name as employee_name,
            COUNT(tickets.id) OVER() as total,
            SUM(tickets.quantity) OVER() as total_quantity'
            );
    }

}
