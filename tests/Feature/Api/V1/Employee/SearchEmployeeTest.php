<?php

namespace Api\V1\Employee;

use Tests\ApiTestCase;

class SearchEmployeeTest extends ApiTestCase
{
    public function test_search_employees(): void
    {
        $response = $this->get(route('employee.search'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'status',
            'message',
        ]);
    }

    public function test_search_employee_with_valid_slug()
    {
        $response = $this->get(route('employee.search', ['slug' => 'John']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'status',
            'message',
        ]);

    }


}
