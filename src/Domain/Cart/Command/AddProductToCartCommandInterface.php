<?php

namespace Domain\Cart\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class AddProductToCartCommandInterface.
 */
interface AddProductToCartCommandInterface extends CommandInterface
{
    /**
     * @return string
     */
    public function getProductId(): string;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;
}
