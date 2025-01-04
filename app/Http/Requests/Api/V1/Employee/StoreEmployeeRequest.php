<?php

namespace App\Http\Requests\Api\V1\Employee;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEmployeeRequest
 * @package App\Http\Requests\Api\V1\Employee
 * Classe responsável por validar os dados de criação de um funcionário
 */
class StoreEmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'cpf' => ['required', new \App\Rules\Cpf(), 'unique:employees']

        ];
    }
}
