<?php

declare(strict_types=1);

namespace App\Controller\Travel;

use App\Attributes\Get;
use App\Abstracts\AbstractController;
use App\Attributes\Post;
use App\Exceptions\ApiProblemException;
use App\UseCase\Travel\Command;
use App\UseCase\Travel\Handler;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;


#[
    Post(
        path: '/calc',
        name: self::class,
    ),
    OA\Post(
        description: 'Подать данные в калькулятор.',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: new Model(type: Command::class, groups: ['default']))
        ),
        tags: ['Калькулятор.'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'HTTP OK',
                content: new OA\JsonContent(ref: '#/components/schemas/empty_response')
            ),
        ]
    ),
]
class Controller extends AbstractController
{
    /** Сделать расчет. */
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        try{
            $command = new Command($request->request->all());
            $this->validate($command);
            return $this->json(data: $handler->handle($command));
        } catch (ApiProblemException $e) {
            return $this->json(errors: [$e->getMessage()],status: Response::HTTP_BAD_REQUEST);
        }

    }
}