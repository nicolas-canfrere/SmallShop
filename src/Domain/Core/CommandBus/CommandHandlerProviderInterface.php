<?php

namespace Domain\Core\CommandBus;

interface CommandHandlerProviderInterface
{
    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface;
}
