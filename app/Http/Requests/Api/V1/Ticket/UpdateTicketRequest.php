<?php

namespace App\Http\Requests\Api\V1\Ticket;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateTicketRequest
 * @package App\Http\Requests\Api\V1\Ticket
 * Classe responsável por validar a requisição de atualização de ticket
 */
class UpdateTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'nullable|integer|min:1',
            'situation' => 'nullable|in:A,I'
        ];
    }
}
