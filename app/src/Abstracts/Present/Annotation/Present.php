<?php

declare(strict_types=1);

namespace App\Abstracts\Present\Annotation;

use App\Abstracts\Present\Contracts\PresenterInterface;

class Present
{
    /**
     * @param class-string<PresenterInterface> $presenter
     */
    public function __construct(public string $presenter, public ?string $sourcePropertyName = null)
    {
    }
}