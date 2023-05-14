<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use PHPUnit\Framework\TestCase;
use SharedKernel\Application\Query\Exception\QueryResultException;
use SharedKernel\Application\Query\Query;
use SharedKernel\Application\Query\QueryResult;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Class QueryBusTest
 * @package App\Infrastructure\Service
 */
class QueryBusTest extends TestCase
{

    public function testHandle()
    {
        $query = new class implements Query {
        };
        $queryResult = new class implements QueryResult {
            public function getResult(): mixed
            {

            }
        };

        $handledStamp = new HandledStamp($queryResult, 'Handler name');

        $bus = $this->getMockBuilder(MessageBusInterface::class)->getMock();
        $bus->expects(self::once())->method('dispatch')
            ->willReturn(new Envelope($query, [$handledStamp]));

        $queryBus = new QueryBus($bus);

        $queryBus->handle($query);
    }

    public function testHandleThrowsQueryReturnException()
    {
        $this->expectException(QueryResultException::class);
        $query = new class implements Query {
        };
        $queryResult = new class {
        };

        $handledStamp = new HandledStamp($queryResult, 'Handler name');

        $bus = $this->getMockBuilder(MessageBusInterface::class)->getMock();
        $bus->expects(self::once())->method('dispatch')
            ->willReturn(new Envelope($query, [$handledStamp]));

        $queryBus = new QueryBus($bus);

        $queryBus->handle($query);
    }
}
