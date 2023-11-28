<?php

declare(strict_types=1);

namespace App\UseCase\Calc;

use App\Abstracts\AbstractCommand;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class ResponseCommand extends AbstractCommand
{
    #[
        Groups(['default']),
        OA\Property(description: 'результат', type: 'integer', default: 10000),
        Assert\NotBlank
    ]
    public string $result;
}