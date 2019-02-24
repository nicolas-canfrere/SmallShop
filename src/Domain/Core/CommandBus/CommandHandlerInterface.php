<?php

namespace Domain\Core\CommandBus;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command);
}
