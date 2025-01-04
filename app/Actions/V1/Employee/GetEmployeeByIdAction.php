<?php

namespace App\Actions\V1\Employee;

use App\Models\Employee;

/**
 * Class GetEmployeeByIdAction
 * @package App\Actions\V1\Employee
 * @property Employee $employee
 * Classe responsável por buscar um funcionário pelo id
 */
class GetEmployeeByIdAction
{
    public function __construct(private Employee $employee)
    {

    }

    /**
     * @param string $id
     * @return Employee|null
     * Método responsável por buscar um funcionário pelo id
     */
    public function execute(string $id): Employee|null
    {
        return $this->employee->find($id);
    }

}
