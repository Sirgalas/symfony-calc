<?php

declare(strict_types=1);

namespace App\UseCase\Travel;


use App\Enums\ChildrenDiscountEnum;
use App\Services\Calculation\CalculationService;
use App\Services\Calculation\Type\CalculationDivision;
use App\Services\Calculation\Type\CalculationMultiple;
use App\Services\Calculation\Type\CalculationPercentageSum;
use App\Services\Calculation\Type\CalculationSubtraction;
use App\Services\Enum\EnumService;
use Monolog\DateTimeImmutable;

class Handler
{
    public const MAX_DISCOUNT = 4500;

    public function __construct(
        private readonly EnumService $enumService,
        private readonly CalculationService $calculationService
    ) {
    }

    public function handle(Command $command): ResponseCommand
    {
        $birthday = new \DateTimeImmutable($command->birthday);
        $now = new \DateTimeImmutable();
        $yearsOld = $birthday->diff($now)->format('%Y');
        $this->enumService->returnValue(ChildrenDiscountEnum::cases(),$yearsOld);
        $percentage = $this->enumService->returnValue(ChildrenDiscountEnum::cases(),$yearsOld);
        $percentageSum = $this->getSumSixOld(
            $yearsOld,
            $this->calculationService->arithmetic(new CalculationPercentageSum(),$command->price,$percentage)
        );

        return new ResponseCommand([
            'result' => $this->calculationService->arithmetic(new CalculationSubtraction(),$command->price,$percentageSum),
            'travel_date' => $command->date_travel
        ]);
    }

    private function getSumSixOld(string $yearsOld, string $percentageSum): string
    {
        if($yearsOld != ChildrenDiscountEnum::SIX->value) {
            return $percentageSum;
        }
        if(self::MAX_DISCOUNT > filter_var($percentageSum, FILTER_VALIDATE_INT)) {
            return $percentageSum;
        }
        return (string) self::MAX_DISCOUNT;
    }
}