<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => $this->generateValidCpf(),
            'situation' => $this->faker->randomElement(['A', 'I']),
        ];
    }

    /**
     * Generate a valid CPF.
     *
     * @return string
     */
    private function generateValidCpf(): string
    {
        $cpf = [];

        // Gerar os primeiros 9 dígitos aleatórios
        for ($i = 0; $i < 9; $i++) {
            $cpf[] = random_int(0, 9);
        }

        // Calcular o primeiro dígito verificador
        $cpf[] = $this->calculateCpfDigit($cpf);

        // Calcular o segundo dígito verificador
        $cpf[] = $this->calculateCpfDigit($cpf);

        // Retornar o CPF como string formatada
        return implode('', $cpf);
    }

    /**
     * Calculate a CPF digit.
     *
     * @param array $cpfPartial
     * @return int
     */
    private function calculateCpfDigit(array $cpfPartial): int
    {
        $weight = count($cpfPartial) + 1;
        $sum = 0;

        foreach ($cpfPartial as $digit) {
            $sum += $digit * $weight--;
        }

        $remainder = $sum % 11;
        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}
