<?php

namespace App\Http\Requests\Api\V1\Employee;
use App\Utils\Cpf as CpfUtils;
use Illuminate\Foundation\Http\FormRequest;
/**
 * Class UpdateEmployeeRequest
 * @package App\Http\Requests\Api\V1\Employee
 * Classe responsável por validar os dados de atualização de um funcionário
 */
class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "name" => ["nullable", "string"],
            'cpf' => ['nullable', new \App\Rules\Cpf()],
            'situation'=> ['nullable', 'in:A,I']

        ];
    }
}
