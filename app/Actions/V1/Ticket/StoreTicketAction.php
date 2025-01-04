<?php

namespace App\Actions\V1\Ticket;

use App\Enums\TicketSituation;
use App\Http\Requests\Api\V1\Ticket\StoreTicketRequest;
use App\Models\Ticket;

/**
 * Class StoreTicketAction
 * @package App\Actions\V1\Ticket
 * Classe responsável por cadastrar um novo ticket
 */
class StoreTicketAction
{
    public function __construct(private readonly Ticket $ticket)
    {

    }

    /**
     * @param StoreTicketRequest $request
     * @return Ticket
     * Método responsável por cadastrar um novo ticket
     *
     */
    public function execute(StoreTicketRequest $request): Ticket
    {
        $dataValidated = $request->validated();
        if (!isset($dataValidated['situation'])) {
            $dataValidated['situation'] = TicketSituation::Active->value;
        }
        return $this->ticket->create($dataValidated);

    }

}
