<?php

namespace App\Actions\V1\Ticket;

use App\Models\Ticket;

class GetTicketByIdAction
{
    public function __construct(private Ticket $ticket)
    {

    }



    /**
     * @param string $ticketId
     * @return Ticket|null
     * Busca um ticket pelo ID
     *
     */
    public function execute(string $ticketId):Ticket|null
    {
       $ticket = $this->ticket->find($ticketId);
       $ticket->load('employee');
         return $ticket;
    }

}
