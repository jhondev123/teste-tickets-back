<?php

namespace App\Interfaces;
/**
 * Interface PDF
 * @package App\Interfaces
 * Interface responsável por definir os métodos de um PDF
 */
interface PDF
{
    public function stream(): string;

    public function download(): string;

    public function save(string $path): void;
}
