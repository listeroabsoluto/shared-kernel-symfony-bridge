<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Service;

use PHPUnit\Framework\TestCase;
use SharedKernel\Application\Command\Command;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CommandBusTest
 * @package App\Infrastructure\Service
 */
class CommandBusTest extends TestCase
{

    public function testHandle()
    {
        $command = new class implements Command {
        };

        $bus = $this->getMockBuilder(MessageBusInterface::class)->getMock();
        $bus->expects(self::once())->method('dispatch')
            ->willReturn(new Envelope($command));
        $commandBus = new CommandBus($bus);

        $commandBus->handle($command);
    }
}
