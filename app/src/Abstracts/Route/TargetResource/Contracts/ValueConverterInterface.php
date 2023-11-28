<?php

namespace App\Abstracts\Route\TargetResource\Contracts;

interface ValueConverterInterface
{
    public function convert(mixed $value): mixed;
}