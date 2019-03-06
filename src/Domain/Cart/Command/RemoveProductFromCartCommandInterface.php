<?php

namespace Domain\Cart\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Interface RemoveProductFromCartCommandInterface.
 */
interface RemoveProductFromCartCommandInterface extends CommandInterface
{
    /**
     * @return string
     */
    public function getProductId(): string;

    /**
     * @return int|string
     */
    public function getQuantity();

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;
}
