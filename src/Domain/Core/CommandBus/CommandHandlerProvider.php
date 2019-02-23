<?php

namespace Domain\Core\CommandBus;


class CommandHandlerProvider implements CommandHandlerProviderInterface, CommandBusMiddlewareInterface
{
    protected $handlers = [];

    public function registerHandler(CommandHandlerInterface $handler, ?string $customId = '')
    {
        if ($customId) {
            $this->handlers[$customId] = $handler;
        } else {
            $this->handlers[get_class($handler)] = $handler;
        }

    }

    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface
    {
        $key = $command->handleBy();

        if (empty($this->handlers[$key])) {
            throw new \InvalidArgumentException();
        }

        return $this->handlers[$key];
    }

    public function execute(CommandInterface $command, callable $next)
    {
        $handler = $this->getHandlerForCommand($command);

        return $handler->handle($command);
    }
}