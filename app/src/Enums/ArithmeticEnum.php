<?php

namespace App\Enums;

use App\Services\Calculation\Type\CalculationAdd;
use App\Services\Calculation\Type\CalculationDivision;
use App\Services\Calculation\Type\CalculationMultiple;
use App\Services\Calculation\Type\CalculationPercentageSum;
use App\Services\Calculation\Type\CalculationSubtraction;

enum ArithmeticEnum: string implements EnumsInterface
{
    case ADD = '+';
    case SUB = '-';
    case DIV = "/";
    case MULTIPLE = "*";

    public function choice(): string
    {
        return  match ($this) {
            self::ADD => CalculationAdd::class,
            self::SUB => CalculationSubtraction::class,
            self::DIV => CalculationDivision::class,
            self::MULTIPLE => CalculationMultiple::class
        };
    }
}
