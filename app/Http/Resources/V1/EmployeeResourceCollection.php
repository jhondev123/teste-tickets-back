<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class EmployeeResourceCollection
 * @package App\Http\Resources\V1
 * Classe responsável por formatar uma coleção de funcionários para serem exibidos na API
 */
class EmployeeResourceCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
