<?php

namespace Domain\Core\CommandBus;

interface CommandBusMiddlewareInterface
{
    public function execute(CommandInterface $command, callable $next);
}
