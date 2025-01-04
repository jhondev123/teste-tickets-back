<?php

namespace App\Actions\V1\Employee;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllEmployeesAction
 * @package App\Actions\V1\Employee
 * @property Employee $employee
 * Classe responsável por buscar todos os funcionários
 */
class GetAllEmployeesAction
{
    public function __construct(private readonly Employee $employee)
    {
    }

    /**
     * @return Collection
     * Método responsável por buscar todos os funcionários
     */
    public function execute(): Collection
    {
        return $this->employee->all();
    }

}
