<?php

namespace SharedKernelSymfonyBridge\Infrastructure;

use Symfony\Component\Uid\Uuid;

/**
 * Class Identifier
 * @package App\Domain\ValueObject
 */
class Identifier extends Uuid
{
    /**
     * @return static
     * @throws \Exception
     */
    public static function generate(): static
    {
        return new static(Uuid::v7());
    }

    /**
     * @param string $uuid
     * @return static
     */
    public static function fromUuid(string $uuid): static
    {
        return new static(Uuid::fromString($uuid));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toRfc4122();
    }
}