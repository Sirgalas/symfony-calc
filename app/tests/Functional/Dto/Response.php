<?php

declare(strict_types=1);

namespace App\Tests\Functional\Dto;

use App\Abstracts\AbstractCommand;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Response extends AbstractCommand
{
    public int $code;
    public string $type;
    public array $content = [];
    public ResponseHeaderBag $headers;

    public function setContent($content): void
    {
        if (!\is_array($content)) {
            $content = [$content];
        }

        $this->content = $content;
    }
}