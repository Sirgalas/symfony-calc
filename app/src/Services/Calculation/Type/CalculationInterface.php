<?php

namespace App\Services\Calculation\Type;

interface CalculationInterface
{
    public function get(string $numOne, string $numTwo): string;
}