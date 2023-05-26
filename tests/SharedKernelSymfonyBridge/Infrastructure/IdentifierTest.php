<?php

namespace SharedKernelSymfonyBridge\Infrastructure;

use PHPUnit\Framework\TestCase;

/**
 * Class IdentifierTest
 * @package App\Domain\ValueObject
 */
class IdentifierTest extends TestCase
{

    public function testNullWillThrowAnException()
    {
        $this->expectException(\TypeError::class);
        Identifier::fromUuid(null);
    }

    public function testInvalidUUIDThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        Identifier::fromUuid("invalid.uuid");
    }

    public function testEmptyUUIDThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        Identifier::fromUuid("");
    }

    public function testValidUUIDWillBeCreated()
    {
        $expected = "55180d98-fd63-4128-add8-0f5c8e429751";
        $actual = Identifier::fromUuid($expected);

        static::assertEquals($expected, $actual);
    }

    public function testToString()
    {
        $expected = "55180d98-fd63-4128-add8-0f5c8e429751";
        $actual = Identifier::fromUuid($expected);

        static::assertEquals($expected, (string)$actual);
    }
}
