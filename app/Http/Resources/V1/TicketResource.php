<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TicketResource
 * @package App\Http\Resources\V1
 * Classe responsável por formatar os dados de um ticket para exibição na API
 */
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $situations = ["A" => "Ativo", "I" => "Inativo"];
        return [
            'id' => $this->id,
            'employee' => $this->employee->name,
            'employee_id' => $this->employee->id ?? null,
            'quantity' => $this->quantity,
            'situation' => $situations[$this->situation],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y H:i:s'),
        ];
    }
}
