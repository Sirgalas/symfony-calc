<?php

namespace App\Enums;



enum ChildrenDiscountEnum: string implements EnumsInterface
{
    case THREE = '3';
    case SIX = '6';
    case TWELVE = '12';

    public function choice(): string
    {
        return match($this) {
            self::THREE => '80',
            self::SIX => '30',
            self::TWELVE => '10'
        };
    }

}
