<?php

namespace Api\V1\Reports;

use App\Models\Ticket;
use Tests\ApiTestCase;

class SearchEmployeeByPeriodTest extends ApiTestCase
{

    private $start_date = '2020-01-01';
    private $end_date = '2050-12-31';
    public function test_search_employee()
    {
        $ticket = Ticket::factory()->create();
        $response = $this->get(route('reports.tickets.by.employee.period', [
            'employee_id' => $ticket->employee_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'status',
            'message',
        ]);
    }

    public function test_search_without_filters()
    {
        $response = $this->get(route('reports.tickets.by.employee.period'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'status',
            'message',
        ]);

    }

}
