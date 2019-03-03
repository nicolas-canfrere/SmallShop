<?php

namespace Domain\Address\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;

/**
 * Class AddressCreateCommandHandler.
 */
class AddressCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @param CommandInterface|AddressCreateCommandInterface $command
     *
     * @return mixed
     */
    public function handle(CommandInterface $command)
    {
    }
}
