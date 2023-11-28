<?php

declare(strict_types=1);

namespace App\Validator\Constraint;


use App\Exceptions\InvalidTypeException;
use App\Exceptions\UnexpectedClassException;
use App\Validator\Asserts\Operand;
use App\Validator\ViolationBuilder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class OperandValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if(!$constraint instanceof OperandConstraint) {
            throw new UnexpectedClassException(OperandConstraint::class,$constraint::class);
        }

        if (null === $value) {
            return;
        }

        if (false === \is_string($value)) {
            throw new InvalidTypeException('string', $value);
        }

        try {
            Operand::validate($value);
        } catch (\InvalidArgumentException $exception) {
            ViolationBuilder::build($this->context, $exception->getMessage(), ['{{ operand }}' => $value]);
        }
    }
}