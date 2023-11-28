<?php

declare(strict_types=1);

namespace App\Services\Calculation\Type;

class CalculationSubtraction implements CalculationInterface
{
    public function get(string $numOne, string $numTwo): string
    {
        return bcsub($numOne,$numTwo);
    }

}