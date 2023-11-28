<?php

declare(strict_types=1);

namespace App\Attributes;

use Symfony\Component\Routing\Annotation\Route;

#[\Attribute]
class Get extends Route
{
    public function getMethods(): array
    {
        return [HttpMethod::GET->name];
    }
}