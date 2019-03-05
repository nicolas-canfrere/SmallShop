<?php

namespace Domain\Cart\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Interface ClearCartCommandInterface
 */
interface ClearCartCommandInterface extends CommandInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;
}
