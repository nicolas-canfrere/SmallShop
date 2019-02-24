<?php

namespace Domain\Core\CommandBus;

use Domain\Core\CommandBus\Exception\NoHandlerForCommandException;

/**
 * Class CommandHandlerProvider
 */
class CommandHandlerProvider implements CommandHandlerProviderInterface, CommandBusMiddlewareInterface
{
    /**
     * @var CommandHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * {@inheritdoc}
     */
    public function registerHandler(CommandHandlerInterface $handler, ?string $customId = ''): void
    {
        $key = $customId ? $customId : get_class($handler);
        $this->handlers[$key] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface
    {
        $key = $command->handleBy();

        if (empty($this->handlers[$key])) {
            throw new NoHandlerForCommandException(get_class($command));
        }

        return $this->handlers[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function execute(CommandInterface $command, callable $next)
    {
        $handler = $this->getHandlerForCommand($command);

        return $handler->handle($command);
    }
}
