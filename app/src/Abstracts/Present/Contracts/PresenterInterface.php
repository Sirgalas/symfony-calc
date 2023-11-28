<?php

namespace App\Abstracts\Present\Contracts;

interface PresenterInterface
{
    public function present(mixed $data): mixed;
}