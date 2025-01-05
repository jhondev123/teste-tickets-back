<?php

namespace App\Actions\V1\Employee;

use App\Http\Requests\Api\V1\SearchEmployeeRequest;
use App\Models\Employee;

class SearchEmployeeAction
{
    public function __construct(Employee $employee)
    {

    }

    public function execute(SearchEmployeeRequest $request)
    {
        $slug = $request->slug ?? '';

        $employees = Employee::query();

        if ($slug) {
            $employees->where(function ($query) use ($slug) {
                $query->where('name', 'like', '%' . $slug . '%')
                    ->orWhere('cpf', 'like', '%' . $slug . '%');
            });
        }

        // Retorna os resultados
        return $employees->get();
    }

}
