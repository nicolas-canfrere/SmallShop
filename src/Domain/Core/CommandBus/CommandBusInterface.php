<?php

namespace Domain\Core\CommandBus;

interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}
