<?php

namespace App\Http\Requests\Api\V1\Ticket;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class StoreTicketRequest
 * @package App\Http\Requests\Api\V1\Ticket
 * Classe responsável por validar a requisição de criação de tickets
 */
class StoreTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'quantity' => 'required|integer|min:1',
            'situation' => 'nullable|in:A',
        ];
    }
}
