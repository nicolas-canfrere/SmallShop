<?php

namespace Domain\Core\CommandBus;


class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerProviderInterface
     */
    protected $commandHandlerProvider;

    /**
     * CommandBus constructor.
     * @param CommandHandlerProviderInterface $commandHandlerProvider
     */
    public function __construct(CommandHandlerProviderInterface $commandHandlerProvider)
    {
        $this->commandHandlerProvider = $commandHandlerProvider;
    }


    public function handle(CommandInterface $command)
    {
        $handler = $this->commandHandlerProvider->getHandlerForCommand($command);

        $handler->handle($command);
    }
}