<?php

namespace App\Actions\V1\Employee;

use App\Enums\EmployeeSituation;
use App\Http\Requests\Api\V1\Employee\StoreEmployeeRequest;
use App\Models\Employee;
use App\Utils\Cpf;

/**
 * Class StoreEmployeeAction
 * @package App\Actions\V1\Employee
 * @property Employee $employee
 * @property StoreEmployeeRequest $request
 * Classe responsável por armazenar um novo funcionário
 */
readonly class StoreEmployeeAction
{
    /**
     * @param Employee $employee
     * O construtor recebe a model pelo container de injeção de dependência
     */
    public function __construct(private Employee $employee)
    {

    }

    /**
     * @param StoreEmployeeRequest $request
     * @return Employee
     * Método responsável por criar um novo funcionário
     *
     */
    public function execute(StoreEmployeeRequest $request): Employee
    {

        $data = $request->validated();
        $data['situation'] = EmployeeSituation::Active->value;
        $data['cpf'] = Cpf::unformat($data['cpf']);
        return $this->employee->create($data);

    }

}
