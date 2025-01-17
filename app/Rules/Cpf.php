<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class Cpf
 * @package App\Rules
 * Classe responsável por executar a validação de CPF
 */
class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!\App\Utils\Cpf::validate($value)) {
            $fail("O $attribute é inválido.");
        }


    }
}
