<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\Abstracts\Present\Presenter;
use App\Validator\ValidationProblem;
use Phpro\ApiProblem\Exception\ApiProblemException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractController extends SymfonyAbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly Presenter $presenter,
        private readonly ValidatorInterface $validator
    ) {
    }
    /** {@inheritdoc} */
    protected function json(
        mixed $data = [],
        int $status = Response::HTTP_OK,
        array $headers = [],
        array $context = [],
        array $meta = [],
        array $errors = []
    ): JsonResponse {
        $this->present($data);

        if (\is_array($data)) {
            $meta = array_merge($meta, ['total' => \count($data)]);
        }


        $data = [
            'data' => $data,
            'errors' => $errors,
            'meta' => $meta,
        ];

        return new JsonResponse(
            $this->serializer->serialize($data, 'json', $context),
            $status,
            $headers + ['Content-Type' => 'application/vnd.api+json'],
            true
        );
    }

    protected function validate(AbstractCommand $command): void
    {
        $violationList = $this->validator->validate($command);

        if (0 !== $violationList->count()) {
            throw new ApiProblemException(new ValidationProblem($violationList));
        }
    }


    private function present(mixed $contents): void
    {
        if (!is_iterable($contents)) {
            $contents = [$contents];
        }

        /** @var mixed $content */
        foreach ($contents as $content) {
            if ($content instanceof AbstractCommand) {
                $this->presenter->present($content);
            }
        }
    }
}