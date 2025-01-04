<?php

namespace App\Enums;

/**
 * Enum EmployeeSituation
 * @package App\Enums
 * Enum que representa as situações do funcionário
 */
enum EmployeeSituation :string
{
    case Active = 'A';
    case Inactive = 'I';

}
