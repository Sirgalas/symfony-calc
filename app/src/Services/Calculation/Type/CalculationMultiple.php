<?php

declare(strict_types=1);

namespace App\Services\Calculation\Type;

class CalculationMultiple implements CalculationInterface
{

    public function get(string $numOne, string $numTwo): string
    {
        return bcmul($numOne,$numTwo);
    }
}