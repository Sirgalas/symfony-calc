<?php

declare(strict_types=1);

namespace App\Abstracts\Route\TargetResource\Subscriber;

use App\Abstracts\AbstractController;
use App\Abstracts\Route\TargetResource\Annotation\TargetResource;
use App\Abstracts\Route\TargetResource\Contracts\ValueConverterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TargetResourceAnnotationSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->handleAttribute($event->getController(), $event->getRequest());
    }

    private function handleAttribute(callable $controller, Request $request): void
    {
        if (!\is_object($controller)) {
            return;
        }

        if (!is_subclass_of($controller, AbstractController::class)) {
            return;
        }

        $this->handleClassAttribute(new \ReflectionClass($controller), $request);
    }

    private function handleClassAttribute(\ReflectionClass $class, Request $request): void
    {
        $attributes = $class->getAttributes(TargetResource::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            /** @var TargetResource $target */
            $target = $attribute->newInstance();
            /** @psalm-var mixed $value */
            $value = $request->attributes->get($target->attributeName);

            if ($target->converter instanceof ValueConverterInterface) {
                /** @psalm-var mixed $value */
                $value = $target->converter->convert($value);
            }

            if (null === $value) {
                return;
            }

        }
    }

    /** {@inheritdoc} */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onKernelController', 255],
            ],
        ];
    }
}