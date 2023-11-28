<?php

declare(strict_types=1);

namespace App\Abstracts\Event;

use App\Exceptions\InvalidTypeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class Subscriber implements EventSubscriberInterface
{
    public function convertRequestJsonContentToArray(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if (\in_array($request->getMethod(), ['GET', 'DELETE'], true)) {
            return;
        }

        if (false !== preg_match('#^/api/#', $request->getRequestUri())) {
            $content = $request->getContent();
            if ('' === $content) {
                return;
            }

            if ('json' === $request->getContentType()) {
                /** @psalm-var array $data */
                $data = json_decode($content, true, 512, \JSON_THROW_ON_ERROR);
                if (\JSON_ERROR_NONE !== json_last_error()) {
                    //phpcs:disable
                    throw new InvalidTypeException('correct json', 'JSON parse error: ' . json_last_error_msg(), Response::HTTP_BAD_REQUEST);
                    //phpcs:enable
                }

                $request->request->replace(\is_array($data) ? $data : []); /* @phpstan-ignore-line */

                return;
            }

            if (0 !== $request->files->count()) {
                return;
            }
            //phpcs:disable
            throw new InvalidTypeException('application/json or upload file', $request->getContentType(), Response::HTTP_BAD_REQUEST);
            //phpcs:enable
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['convertRequestJsonContentToArray', 254],
            ],
        ];
    }
}