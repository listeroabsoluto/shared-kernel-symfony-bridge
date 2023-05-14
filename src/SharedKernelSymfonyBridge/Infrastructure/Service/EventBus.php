<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use SharedKernel\Domain\DomainEvent;
use SharedKernel\Domain\DomainEventRecorder;
use SharedKernel\Domain\EventBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventBus
 * @package App\App\Infrastructure\Service
 */
class EventBus implements EventBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * CommandBus constructor.
     * @param MessageBusInterface $eventBus
     */
    public function __construct(MessageBusInterface $eventBus)
    {
        $this->messageBus = $eventBus;
    }

    /**
     * @param DomainEvent $domainEvent
     */
    public function handle(DomainEvent $domainEvent): void
    {
        $this->messageBus->dispatch(new Envelope($domainEvent));
    }

    /**
     * @param DomainEventRecorder $domainEventRecorder
     */
    public function dispatchDomainEvents(DomainEventRecorder $domainEventRecorder): void
    {
        foreach ($domainEventRecorder->getRegisteredDomainEvents() as $event) {
            $this->handle($event);
        }
    }
}