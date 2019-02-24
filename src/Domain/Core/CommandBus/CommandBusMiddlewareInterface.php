<?php

namespace Domain\Core\CommandBus;

/**
 * Interface CommandBusMiddlewareInterface
 */
interface CommandBusMiddlewareInterface
{
    /**
     * @param CommandInterface $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(CommandInterface $command, callable $next);
}
