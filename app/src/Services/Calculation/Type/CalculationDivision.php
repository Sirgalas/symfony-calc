<?php

declare(strict_types=1);

namespace App\Services\Calculation\Type;

class CalculationDivision implements CalculationInterface
{

    public function get(string $numOne, string $numTwo): string
    {
        return bcdiv($numOne, $numTwo);
    }
}