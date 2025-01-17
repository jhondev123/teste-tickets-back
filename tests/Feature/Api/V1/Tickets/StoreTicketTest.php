<?php

namespace Api\V1\Tickets;

use App\Models\Employee;
use Tests\ApiTestCase;

class StoreTicketTest extends ApiTestCase
{
    public function test_store_ticket():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 5
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "message",
            "status",
            "data"
        ]);
    }

    public function test_store_ticket_with_employee_not_found():void
    {
        $response = $this->post(route('tickets.store'), [
            'employee_id' => 999,
            'quantity' => 5
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "employee_id"
            ]
        ]);
    }

    public function test_store_ticket_with_employee_invalid():void
    {
        $response = $this->post(route('tickets.store'), [
            'employee_id' => 'invalid',
            'quantity' => 5
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "employee_id"
            ]
        ]);
    }

    public function test_store_ticket_with_quantity_invalid():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 'invalid'
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "quantity"
            ]
        ]);

    }

    public function test_store_ticket_with_quantity_less_than_1():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 0
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "quantity"
            ]
        ]);

    }

    public function test_store_ticket_without_data():void
    {
        $response = $this->post(route('tickets.store'), []);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors"=> [
                "employee_id",
                "quantity"
            ]
        ]);
    }
    public function test_store_ticket_with_situation():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 5,
            'situation' => 'A'
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "message",
            "status",
            "data"
        ]);

    }
    public function test_store_ticket_with_invalid_situation():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 5,
            'situation' => 'invalid'
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "situation"
            ]
        ]);
    }

    public function test_store_ticket_with_situation_inactive():void
    {
        $employee = Employee::factory()->create();
        $response = $this->post(route('tickets.store'), [
            'employee_id' => $employee->id,
            'quantity' => 5,
            'situation' => 'I'
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "situation"
            ]
        ]);

    }

}
