<?php

namespace Api\V1\Reports;

use App\Models\Employee;
use App\Models\Ticket;
use Tests\ApiTestCase;

class GenerateReportTest extends ApiTestCase
{
    public function test_generate_report(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->post(route('reports.tickets.generate', [
            'employee_id' => $ticket->employee_id,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31'
        ]));

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/pdf');

        $this->assertNotEmpty($response->getContent(), 'O conteúdo do PDF está vazio.');

    }

    public function test_generate_report_without_filters()
    {
        $response = $this->post(route('reports.tickets.generate'));

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/pdf');

        $this->assertNotEmpty($response->getContent(), 'O conteúdo do PDF está vazio.');

    }



}
