<?php

namespace App\Http\Requests\Api\V1\Employee;

use App\Utils\Cpf as CpfUtil;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->cpf) {
            $this->merge([
                'cpf' => CpfUtil::unformat($this->cpf)
            ]);
        }
    }

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
