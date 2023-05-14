<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use SharedKernel\Application\Command\Command;
use SharedKernel\Application\Command\CommandBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CommandBus
 * @package App\Infrastructure\Service
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * CommandBus constructor.
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $this->messageBus->dispatch(new Envelope($command));
    }
}