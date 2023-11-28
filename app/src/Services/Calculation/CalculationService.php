<?php

declare(strict_types=1);

namespace App\Services\Calculation;

use App\Services\Calculation\Type\CalculationInterface;

class CalculationService
{
    public function arithmetic(CalculationInterface $calculation, string $numOne, string $numTwo): string
    {

        $calculationClass = new \ReflectionClass($calculation);
        return $calculation->get($numOne, $numTwo);
    }
}