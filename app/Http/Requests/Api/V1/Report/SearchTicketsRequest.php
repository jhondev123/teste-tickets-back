<?php

namespace App\Http\Requests\Api\V1\Report;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SearchTicketsRequest
 * @package App\Http\Requests\Api\V1\Report
 * Classe responsável por validar a requisição de busca de tickets
 */
class SearchTicketsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'employee_id' => 'nullable|integer|exists:employees,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }
}
