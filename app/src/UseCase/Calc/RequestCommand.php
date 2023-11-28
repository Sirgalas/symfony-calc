<?php

declare(strict_types=1);

namespace App\UseCase\Calc;

use App\Abstracts\AbstractCommand;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Asserts;

class RequestCommand extends AbstractCommand
{
    #[
        Groups(['default']),
        Assert\NotBlank(),
        OA\Property(type: 'string')
    ]
    public string $numOne;
    #[
        Groups(['default']),
        Assert\NotBlank(),
        OA\Property(type: 'string')
    ]
    public string $numTwo;
    #[
        Groups(['default']),
        Assert\NotBlank(),
        OA\Property(type: 'string'),
        Asserts\Operand
    ]
    public string $operand;
}