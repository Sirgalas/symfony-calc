<?php

declare(strict_types=1);

namespace App\Controller\Attributes;

#[\Attribute]
class Get
{
    public function getMethods(): array
    {
        return [HttpMethod::GET->name];
    }
}