<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Type;

use PHPUnit\Framework\TestCase;

/**
 *
 */
class IdentifierTypeTest extends TestCase
{

    public function testGetName()
    {
        $identifier = new class extends IdentifierType {

            protected function getClass()
            {
                return IdentifierType::class;
            }

            protected function fromUuid($value)
            {
                // TODO: Implement fromUuid() method.
            }
        };

        static::assertEquals(IdentifierType::NAME, $identifier->getName());

        $ref = new \ReflectionMethod($identifier, 'getUidClass');
        $ref->setAccessible(true);

        static::assertEquals(IdentifierType::class, $ref->invoke($identifier));
    }
}
