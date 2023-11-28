<?php

declare(strict_types=1);

namespace App\Services\Calculation\Type;

class CalculationPercentageSum implements CalculationInterface
{

    public function get(string $numOne, string $numTwo): string
    {
        return (new CalculationMultiple())->get((new CalculationDivision())->get($numOne,"100"),$numTwo);
    }
}