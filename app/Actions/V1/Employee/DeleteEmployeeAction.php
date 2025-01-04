<?php

namespace App\Actions\V1\Employee;

use App\Models\Employee;

/**
 * Class DeleteEmployeeAction
 * @package App\Actions\V1\Employee
 * @property Employee $employee
 * Classe responsável por deletar um funcionário
 */
class DeleteEmployeeAction
{
    public function __construct(private readonly Employee $employee)
    {
    }

    /**
     * @param string $employeeId
     * @return bool
     * Método responsável por deletar um funcionário
     */
    public function execute(string $employeeId): bool
    {
        $employee = $this->employee->find($employeeId);
        if (!$employee) {
            throw new \DomainException('Employee not found', 404);
        }
        return $employee->delete();

    }


}
