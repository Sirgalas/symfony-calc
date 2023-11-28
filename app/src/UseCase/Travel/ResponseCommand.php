<?php

declare(strict_types=1);

namespace App\UseCase\Travel;

use App\Abstracts\AbstractCommand;

class ResponseCommand extends AbstractCommand
{
    public float $result;

    public string $travel_date;

    public function setDate(string $item = null)
    {
        $this->travel_date = $item;
        if(!$item) {
            $this->travel_date = date('d.m.Y');
        }
    }

}