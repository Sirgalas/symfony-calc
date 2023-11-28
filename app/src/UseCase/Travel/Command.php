<?php

declare(strict_types=1);

namespace App\UseCase\Travel;

use App\Abstracts\AbstractCommand;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends AbstractCommand
{
    #[
        Groups(['default']),
        OA\Property(description: 'Базовая стоимость', type: 'string', default: 10000),
        Assert\NotBlank
    ]
    public string $price;
    #[
        Groups(['default']),
        OA\Property(description: "Дата рождения", type: "string"),
        Assert\NotBlank
    ]
    public string $birthday;

    #[
        Groups(['default']),
        OA\Property(description: "Дата путешествия", type: "string"),
    ]
    public ?string $travel_date = null;

    public function setPrice($item): void
    {
        $this->price = (string) $item;
    }


}