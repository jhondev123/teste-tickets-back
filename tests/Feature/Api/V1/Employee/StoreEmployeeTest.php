<?php

namespace Api\V1\Employee;

use App\Enums\EmployeeSituation;
use App\Models\Employee;
use Tests\ApiTestCase;

class StoreEmployeeTest extends ApiTestCase
{
    public function test_store_employee(): void
    {
        $response = $this->post(route('employees.store'), [
            'name' => 'John Doe',
            'cpf' => '490.778.680-89'
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data',
            'status',
            'message',
        ]);
    }

    public function test_store_employee_with_invalid_cpf(): void
    {
        $response = $this->post(route('employees.store'), [
            'name' => 'John Doe',
            'cpf' => '12345678901'
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'cpf',
            ],
        ]);
    }

    public function test_store_employee_with_cpf_without_pontution(): void
    {
        $response = $this->post(route('employees.store'), [
            'name' => 'John Doe',
            'cpf' => '49077868089'
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data'
        ]);

    }

    public function test_store_employee_without_name(): void
    {
        $response = $this->post(route('employees.store'), [
            'cpf' => '490.778.680-89'
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
    }

    public function test_store_employee_without_situation(): void
    {
        $response = $this->post(route('employees.store'), [
            'name' => 'John Doe',
            'cpf' => '490.778.680-89',
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
    }

    public function test_store_employee_without_situation_and_situation_is_active(): void
    {
        $employeeData = [
            'name' => 'John Doe',
            'cpf' => '49077868089',
        ];

        $response = $this->postJson(route('employees.store'), $employeeData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'cpf',
                    'situation',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('employees', [
            'cpf' => $employeeData['cpf'],
            'name' => $employeeData['name'],
            'situation' => EmployeeSituation::Active->value
        ]);

    }

    public function test_store_employee_with_cpf_alredy_exists(): void
    {
        $employee = Employee::factory()->create([
            'cpf' => '490.778.680-89'
        ]);
        $response = $this->post(route('employees.store'), [
            'name' => 'John Doe',
            $employee->cpf
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'cpf',
            ],
        ]);

    }


}
