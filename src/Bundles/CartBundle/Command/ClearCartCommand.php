<?php

namespace Bundles\CartBundle\Command;

use Domain\Cart\Command\ClearCartCommandHandler;
use Domain\Cart\Command\ClearCartCommandInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class ClearCartCommand.
 */
class ClearCartCommand implements ClearCartCommandInterface
{
    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * ClearCartCommand constructor.
     *
     * @param CustomerInterface|null $customer
     */
    public function __construct(?CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return ClearCartCommandHandler::class;
    }
}
