<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class TransactionalTest extends TestCase
{

    public function testExecute()
    {
        $closure = function () {
            return 'transactional result';
        };

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects(self::once())->method('wrapInTransaction')
            ->willReturn('transactional result');
        $transactional = new Transactional($em);

        $actual = $transactional->execute($closure);

        static::assertEquals('transactional result', $actual);
    }
}
