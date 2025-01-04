<?php

namespace App\Actions\V1\Employee;

use App\Http\Requests\Api\V1\Employee\UpdateEmployeeRequest;
use App\Models\Employee;

/**
 * Class UpdateEmployeeAction
 * @package App\Actions\V1\Employee
 * @property UpdateEmployeeRequest $request
 * @property Employee $employee
 * Classe responsável por atualizar um funcionário
 */
readonly class UpdateEmployeeAction
{

    /**
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return Employee
     * @throws \DomainException
     * Método responsável por atualizar um funcionário
     */
    public function execute(UpdateEmployeeRequest $request, Employee $employee): Employee
    {
        $data = $this->validateCpf($request, $employee);
        $employee->update($data);
        return $employee;
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return array
     * @throws \DomainException
     * Método responsável por validar o CPF, caso seja informado o CPF e o CPF seja diferente do CPF atual
     * é verificado se o CPF já existe em outros funcionários, caso seja o mesmo ele ignora
     *
     */
    public function validateCpf(UpdateEmployeeRequest $request, Employee $employee): array
    {
        $data = $request->validated();
        unset($data['cpf']);
        if ($request->has('cpf') && $request->cpf !== $employee->cpf) {
            if ($this->verifyCpfAlreadyExists($employee)) {
                throw new \DomainException('CPF already exists', 422);
            }
            $data['cpf'] = $request->cpf;
        }
        return $data;
    }

    /**
     * @param Employee $employee
     * @return bool
     * Método responsável por verificar se o CPF já existe em outros funcionários
     */
    public function verifyCpfAlreadyExists(Employee $employee):bool
    {
        $employee = Employee::where('cpf', $employee->cpf)->first();
        if ($employee) {
            return true;
        }
        return false;
    }

}
