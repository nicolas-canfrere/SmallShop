<?php

namespace Domain\Tests\Core\CommandBus;


use Domain\Core\CommandBus\CommandBus;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandHandlerProvider;
use Domain\Core\CommandBus\CommandInterface;
use PHPUnit\Framework\TestCase;

class CommandBusTest extends TestCase
{
    /**
     * @test
     */
    public function canHandle()
    {
        $commandHandlerProvider = new CommandHandlerProvider();
        $handlerOne = $this->createHandler();
        $handlerTwo = $this->createHandler();

        $command = $this->createMock(CommandInterface::class);
        $command->method('handleBy')->willReturn('handler:two');
        $handlerOne
            ->expects($this->never())
            ->method('handle');
        $handlerTwo
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($command));

        $commandHandlerProvider->registerHandler($handlerOne, 'handler:one');
        $commandHandlerProvider->registerHandler($handlerTwo, 'handler:two');

        $commandBus = new CommandBus([$commandHandlerProvider]);

        $commandBus->handle($command);
    }

    private function createHandler()
    {
        return $this->getMockBuilder(CommandHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();
    }
}
