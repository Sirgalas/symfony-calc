<?php

declare(strict_types=1);

namespace App\Controller\Calc;

use App\Abstracts\AbstractController;
use App\UseCase\Calc\Handler;
use App\UseCase\Calc\RequestCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractController
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $command = new RequestCommand($request->request->all());
        $this->validate($command);
        return $this->json($handler->handle($command));
    }
}