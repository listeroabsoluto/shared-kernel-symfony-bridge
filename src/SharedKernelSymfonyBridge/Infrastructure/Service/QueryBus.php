<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use SharedKernel\Application\Query\Exception\QueryResultException;
use SharedKernel\Application\Query\Query;
use SharedKernel\Application\Query\QueryBusInterface;
use SharedKernel\Application\Query\QueryResult;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Class QueryBus
 * @package App\Application\Service
 */
class QueryBus implements QueryBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * QueryBus constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param Query $query
     * @return QueryResult
     */
    public function handle(Query $query): QueryResult
    {
        /** @var HandledStamp $handlerResult */
        $handlerResult = $this->messageBus->dispatch(new Envelope($query))
            ->last(HandledStamp::class);
        if (null === $handlerResult || !($result = $handlerResult->getResult()) instanceof QueryResult) {
            throw new QueryResultException(
                \sprintf(
                    'Query handler for %s should return an instance of %s, instance of %s given',
                    \get_class($query),
                    QueryResult::class,
                    $handlerResult ? \get_class($handlerResult) : 'null'
                )
            );
        }

        return $result;
    }

}