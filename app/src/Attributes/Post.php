<?php

declare(strict_types=1);

namespace App\Attributes;


use Symfony\Component\Routing\Annotation\Route;
#[\Attribute]
class Post extends Route
{
    public function getMethods(): array
    {
        return [HttpMethod::POST->name];
    }
}