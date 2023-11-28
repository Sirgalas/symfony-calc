<?php

declare(strict_types=1);

namespace App\UseCase\Calc;

use App\Enums\ArithmeticEnum;
use App\Services\Calculation\CalculationService;
use App\Services\Enum\EnumService;

class Handler
{
    public function __construct(
        private readonly EnumService $enumService,
        private readonly CalculationService $calculationService
    ) {
    }

    public function handle(RequestCommand $command): ResponseCommand
    {
        $operandClass = $this->enumService->returnValue(ArithmeticEnum::cases(),$command->operand);
        return new ResponseCommand(['result' => $this->calculationService->arithmetic(new $operandClass(),$command->numOne,$command->numTwo)]);
    }
}