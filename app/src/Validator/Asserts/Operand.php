<?php

declare(strict_types=1);

namespace App\Validator\Asserts;

use App\Exceptions\InvalidTypeException;
use Webmozart\Assert\Assert as WebmozartAssert;

class Operand
{
    public static function validate(string $value): void
    {
        try {
            WebmozartAssert::regex($value, '#^[-+/*]{1}$#');
        } catch (\InvalidArgumentException) {
            throw new InvalidTypeException('slug', $value);
        }
    }
}