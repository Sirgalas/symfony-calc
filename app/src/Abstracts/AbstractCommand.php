<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\Exceptions\InvalidTypeException;
use App\Exceptions\LogicException;


abstract class AbstractCommand
{
    public function __construct(array $properties)
    {
        /** @psalm-var mixed $value */
        foreach ($properties as $property => $value) {
            if (true === \is_string($value)) {
                $value = trim($value);


            }

            if (null === $value) {
                continue;
            }

            $method = 'set' . str_replace(
                    ' ',
                    '',
                    mb_convert_case(
                        str_replace('_', ' ', (string) $property),
                        \MB_CASE_TITLE,
                        'UTF-8'
                    )
                );

            if (\is_callable([$this, $method])) {
                $this->{$method}($value); /* @phpstan-ignore-line */

                continue;
            }

            if (property_exists(static::class, $property)) {
                $this->{$property} = $value; /* @phpstan-ignore-line */
            }
        }
    }


    private function getArrayFromJson(string $value): array
    {
        try {
            $decoded = json_decode($value, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new InvalidTypeException('json', $value);
        }

        if (false === \is_array($decoded)) {
            throw new InvalidTypeException('json object', $value);
        }

        return $decoded;
    }

    final public static function hasProperty(self $command, string $property): bool
    {
        return property_exists($command::class, $property);
    }

    final public static function getValueByProperty(self $command, string $property): mixed
    {
        if (self::hasProperty($command, $property)) {
            return $command->{$property};
        }

        throw new LogicException("{$property} not found in class.");
    }
}