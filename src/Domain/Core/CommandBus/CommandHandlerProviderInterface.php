<?php

namespace Domain\Core\CommandBus;

use Domain\Core\CommandBus\Exception\NoHandlerForCommandException;

/**
 * Interface CommandHandlerProviderInterface
 */
interface CommandHandlerProviderInterface
{
    /**
     * @param CommandHandlerInterface $handler
     * @param string|null $customId
     */
    public function registerHandler(CommandHandlerInterface $handler, ?string $customId = ''): void;

    /**
     * @param CommandInterface $command
     *
     * @return CommandHandlerInterface
     * @throws NoHandlerForCommandException
     */
    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface;
}
