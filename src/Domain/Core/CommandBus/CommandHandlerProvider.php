<?php

namespace Domain\Core\CommandBus;


class CommandHandlerProvider implements CommandHandlerProviderInterface
{
    protected $handlers = [];

    public function registerHandler(CommandHandlerInterface $handler)
    {
        $this->handlers[get_class($handler)] = $handler;
    }

    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface
    {
        $key = $command->handleBy();

        if (empty($this->handlers[$key])) {
            throw new \InvalidArgumentException();
        }

        return $this->handlers[$key];
    }
}