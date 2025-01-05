<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchTicketsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $situations = ["A" => "Ativo", "I" => "Inativo"];

        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'employee' => $this->employee->name,
            'quantity' => $this->quantity,
            'situation' => $situations[$this->situation],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y H:i:s'),

        ];
    }
}
