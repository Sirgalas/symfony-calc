<?php

declare(strict_types=1);

namespace App\UseCase\Travel;

use App\Abstracts\AbstractCommand;

class ResponseCommand extends AbstractCommand
{
    public string $result;

    public string $travel_date;


}