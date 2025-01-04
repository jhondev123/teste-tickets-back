<?php

namespace App\Enums;
/**
 * Enum TicketSituation
 * @package App\Enums
 * Enum que representa as situações do ticket
 */
enum TicketSituation:string
{
    case Active = 'A';
    case Inactive = 'I';

}
