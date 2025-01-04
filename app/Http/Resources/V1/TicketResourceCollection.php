<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class TicketResourceCollection
 * @package App\Http\Resources\V1
 * Classe responsável por formatar uma coleção de tickets para exibição na API
 */
class TicketResourceCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
