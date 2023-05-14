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
     * @return Identifier
     * @throws \Exception
     */
    public static function generate(): Identifier
    {
        return new static(Uuid::v7());
    }

    /**
     * @param string $uuid
     * @return Identifier
     */
    public static function fromUuid(string $uuid): Identifier
    {
        return new static(Uuid::fromString($uuid));
    }

    /**
     * @return Uuid
     */
    public function getValue(): Uuid
    {
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue()->toRfc4122();
    }
}