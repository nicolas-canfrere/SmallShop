<?php

namespace Domain\Core\CommandBus;

/**
 * Interface CommandBusInterface
 */
interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return mixed
     */
    public function handle(CommandInterface $command);
}
