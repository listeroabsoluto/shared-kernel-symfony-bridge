<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\DomainEvent;
use SharedKernel\Domain\DomainEventRecorder;
use SharedKernel\Domain\DomainObject;
use SharedKernel\Domain\Traits\AggregateRootTrait;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventBusTest
 * @package App\Infrastructure\Service
 */
class EventBusTest extends TestCase
{

    public function testHandle()
    {
        $domainEvent = new class implements DomainEvent {
            public function setDomainEventDateTime(\DateTimeImmutable $dateTime) {}
            public function getDateTime(): \DateTimeImmutable {}
            public function isEqualsTo(DomainObject $domainObject): bool {}
            public function getHashCode(): string {}
        };

        $bus = $this->getMockBuilder(MessageBusInterface::class)->getMock();
        $bus->expects(self::once())->method('dispatch')
            ->willReturn(new Envelope($domainEvent));
        $eventBus = new EventBus($bus);

        $eventBus->handle($domainEvent);
    }

    public function testDispatchDomainEvents()
    {
        $domainEvent = new class implements DomainEvent {
            public function setDomainEventDateTime(\DateTimeImmutable $dateTime) {}
            public function getDateTime(): \DateTimeImmutable { return new \DateTimeImmutable();}
            public function isEqualsTo(DomainObject $domainObject): bool {}
            public function getHashCode(): string {}
        };

        $recorder = new class implements DomainEventRecorder {
            use AggregateRootTrait;
        };

        $recorder->recordDomainEvent($domainEvent);

        $bus = $this->getMockBuilder(MessageBusInterface::class)->getMock();
        $bus->expects(self::once())->method('dispatch')
            ->willReturn(new Envelope($domainEvent));
        $eventBus = new EventBus($bus);

        $eventBus->dispatchDomainEvents($recorder);
    }
}
